<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Katalog';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()->schema([
                // ⚡ SINKRONISASI: Tambah input manual untuk ID Kategori karena tipe data VARCHAR non-increment
                Forms\Components\TextInput::make('id_kategori')
                    ->label('ID Kategori')
                    ->required()
                    ->placeholder('Contoh: KAT006')
                    ->maxLength(10)
                    ->disabledOn('edit'),

                Forms\Components\TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(50),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_kategori')
                    ->label('ID Kategori')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('buku_count')
                    ->label('Jumlah Koleksi')
                    ->counts('buku')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // ⚡ SINKRONISASI: Hapus fungsi detach() karena database menggunakan ON DELETE RESTRICT
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
            'index' => Pages\ListKategoris::route('/')
        ]; 
    }

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['super_admin']);
    }
}