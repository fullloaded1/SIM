<?php

namespace App\Filament\Widgets;

use App\Models\Buku;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStokBuku extends BaseWidget
{
    protected static ?string $heading = 'Peringatan Logistik: Stok Buku Menipis (≤ 2 Unit)';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Buku::query()->where('stok_tersedia', '<=', 2))
            ->columns([
                Tables\Columns\TextColumn::make('isbn')->label('ISBN'),
                Tables\Columns\TextColumn::make('judul')->label('Judul Buku'),
                Tables\Columns\TextColumn::make('stok_total')->label('Total Inventaris'),
                Tables\Columns\TextColumn::make('stok_tersedia')
                    ->label('Tersedia di Rak')
                    ->badge()
                    ->color('danger'),
            ]);
    }
}