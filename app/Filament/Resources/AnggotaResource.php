<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Models\Anggota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Data Anggota';
    protected static ?string $pluralModelLabel = 'Data Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    // ⚡ SINKRONISASI: Input manual ID Anggota karena tipe data VARCHAR non-increment
                    TextInput::make('id_anggota')
                        ->label('ID Anggota')
                        ->required()
                        ->placeholder('Contoh: ANG004')
                        ->maxLength(15)
                        ->disabledOn('edit'),

                    TextInput::make('nama')
                        ->label('Nama Lengkap Anggota')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('email')
                        ->label('Alamat Email')
                        ->email()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),

                    // ⚡ SINKRONISASI: Mengubah kolom no_hp menjadi no_telp sesuai berkas .sql asli
                    TextInput::make('no_telp')
                        ->label('Nomor Telepon')
                        ->tel()
                        ->maxLength(15),

                    DatePicker::make('tgl_daftar')
                        ->label('Tanggal Pendaftaran')
                        ->default(now())
                        ->required(),

                    // ⚡ SINKRONISASI: Mengubah status_aktif boolean menjadi ENUM status ('aktif', 'nonaktif')
                    Select::make('status')
                        ->label('Status Keanggotaan')
                        ->options([
                            'aktif' => 'Aktif',
                            'nonaktif' => 'Non-Aktif',
                        ])
                        ->default('aktif')
                        ->required(),

                    Textarea::make('alamat')
                        ->label('Alamat Rumah')
                        ->columnSpanFull()
                        ->rows(3),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_anggota')
                    ->label('ID Anggota')
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->sortable(),

                // ⚡ SINKRONISASI: Menampilkan kolom no_telp
                TextColumn::make('no_telp')
                    ->label('No. Telepon')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('tgl_daftar')
                    ->label('Tgl Daftar')
                    ->date('d M Y')
                    ->sortable(),

                // ⚡ SINKRONISASI: Badge status ENUM
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('peminjaman_count')
                    ->label('Total Pinjam')
                    ->counts('peminjaman'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Non-Aktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // ⚡ SINKRONISASI: Penghapusan biasa dibiarkan mengalir agar divalidasi langsung oleh Trigger BEFORE DELETE MySQL kamu
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
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}