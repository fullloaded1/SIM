<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Peminjaman Buku';
    protected static ?string $pluralModelLabel = 'Peminjaman Buku';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'dipinjam')->count();
    }

    protected static ?string $navigationBadgeColor = 'warning';

    protected static ?string $recordTitleAttribute = 'id_peminjaman';

    public static function getGloballySearchableAttributes(): array
    {
        return ['id_peminjaman', 'anggota.nama'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('id_peminjaman')
                        ->label('ID Peminjaman')
                        ->required()
                        ->placeholder('Contoh: PMJ001')
                        ->maxLength(15)
                        ->disabledOn('edit'),

                    Select::make('id_anggota')
                        ->relationship('anggota', 'nama') 
                        ->label('Nama Anggota')
                        ->preload()
                        ->searchable()
                        ->required(),

                    Select::make('id_petugas')
                        ->relationship('petugas', 'nama')
                        ->label('Petugas Pelayan')
                        ->preload()
                        ->searchable()
                        ->required(),

                    DatePicker::make('tgl_pinjam')
                        ->label('Tanggal Peminjaman')
                        ->default(now())
                        ->required(),

                    DatePicker::make('tgl_kembali')
                        ->label('Batas Pengembalian (Jatuh Tempo)')
                        ->default(now()->addDays(7))
                        ->required(),

                    DatePicker::make('tgl_kembali_aktual')
                        ->label('Tanggal Pengembalian Riil'),

                    Select::make('status')
                        ->options([
                            'dipinjam' => 'Dipinjam',
                            'dikembalikan' => 'Sudah Kembali', // ⚡ SINKRONISASI DATABASE: Menggunakan value 'dikembalikan' sesuai ENUM MySQL
                            'terlambat' => 'Terlambat',
                        ])
                        ->default('dipinjam')
                        ->required(),

                    TextInput::make('denda')
                        ->label('Denda (Rp)')
                        ->numeric()
                        ->default(0.00),

                    Repeater::make('detailPeminjaman')
                        ->relationship('detailPeminjaman')
                        ->label('Daftar Buku Yang Dipinjam')
                        ->schema([
                            Select::make('id_buku')
                                ->relationship('buku', 'judul')
                                ->label('Judul Buku')
                                ->preload()
                                ->searchable()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, Forms\Set $set) {
                                    $buku = Buku::find($state);
                                    if ($buku && $buku->stok_tersedia <= 0) {
                                        Notification::make()
                                            ->title('Stok Buku Habis!')
                                            ->body("Maaf Pip, stok buku '{$buku->judul}' sedang kosong.")
                                            ->danger()
                                            ->send();
                                    }
                                }),
                            TextInput::make('jumlah')
                                ->label('Jumlah Porsi')
                                ->numeric()
                                ->default(1)
                                ->required(),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->createItemButtonLabel('Tambah Koleksi Buku Pinjaman')
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_peminjaman')
                    ->label('ID Pinjam')
                    ->sortable(),

                TextColumn::make('anggota.nama')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tgl_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tgl_kembali')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tgl_kembali_aktual')
                    ->label('Tgl Kembali')
                    ->date('d M Y')
                    ->placeholder('Belum Kembali'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success', // ⚡ SINKRONISASI DATABASE
                        'terlambat' => 'danger',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'dikembalikan' => 'Sudah Kembali',
                        default => ucfirst($state)
                    }),

                TextColumn::make('denda')
                    ->label('Denda')
                    ->money('IDR'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Sudah Kembali',
                        'terlambat' => 'Terlambat',
                    ]),
            ])
            ->actions([
                // ⚡ TOMBOLAKSI BUGAR: Menggunakan status 'dikembalikan' agar lolos validasi ENUM database
                Tables\Actions\Action::make('kembalikanBuku')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Peminjaman $record) => $record->status === 'dipinjam')
                    ->requiresConfirmation()
                    ->action(function (Peminjaman $record) {
                        $record->update([
                            'status' => 'dikembalikan', // ⚡ TETAP 'dikembalikan' SESUAI ENUM MYSQL
                            'tgl_kembali_aktual' => now(),
                        ]);

                        foreach ($record->detailPeminjaman as $detail) {
                            if ($detail->buku) {
                                $detail->buku->increment('stok_tersedia', $detail->jumlah);
                            }
                        }

                        Notification::make()
                            ->title('Buku Berhasil Dikembalikan!')
                            ->body('Status transaksi bugar dan stok buku otomatis dipulihkan kembali, Pip.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamans::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}