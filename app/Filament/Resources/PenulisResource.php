<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenulisResource\Pages;
use App\Models\Penulis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenulisResource extends Resource
{
    protected static ?string $model = Penulis::class;
    
    // ⚡ SESUAIKAN: Mengganti icon menjadi profil orang agar visual sidebar makin berkelas dan beda dari yang lain
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    
    protected static ?string $navigationGroup = 'Katalog';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                // ⚡ FIX: Sesuaikan properti data form ke 'nama_penulis'
                Forms\Components\TextInput::make('nama_penulis')
                    ->label('Nama Penulis')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kebangsaan')
                    ->required()
                    ->maxLength(255),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // ⚡ FIX: Sesuaikan pemanggilan kolom tabel dari 'nama' menjadi 'nama_penulis' agar teksnya muncul kembali
            Tables\Columns\TextColumn::make('nama_penulis')
                ->label('Nama Penulis')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('kebangsaan')
                ->searchable(),
            Tables\Columns\TextColumn::make('buku_count')
                ->label('Koleksi Buku')
                ->counts('buku')
                ->sortable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
                ->before(function (Penulis $record) {
                    // ⚡ OPTIMASI: Eager loading relasi bertingkat agar proses hapus bersih berjalan instan
                    $record->load(['buku.peminjaman.pengembalian']);
                    
                    foreach ($record->buku as $buku) {
                        foreach ($buku->peminjaman as $pinjam) {
                            if ($pinjam->pengembalian()->exists()) {
                                $pinjam->pengembalian()->delete();
                            }
                            $pinjam->delete();
                        }
                        $buku->delete();
                    }
                }),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                    ->before(function (\Illuminate\Support\Collection $records) {
                        // ⚡ OPTIMASI BULK: Load semua relasi sekaligus untuk menghemat beban query database MySQL
                        $records->load(['buku.peminjaman.pengembalian']);
                        
                        foreach ($records as $record) {
                            foreach ($record->buku as $buku) {
                                foreach ($buku->peminjaman as $pinjam) {
                                    if ($pinjam->pengembalian()->exists()) {
                                        $pinjam->pengembalian()->delete();
                                    }
                                    $pinjam->delete();
                                }
                                $buku->delete();
                            }
                        }
                    }),
            ]),
        ]);
    }

    public static function getPages(): array 
    { 
        return [
            'index' => Pages\ListPenulises::route('/'),
        ]; 
    }

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['super_admin']);
    }
}