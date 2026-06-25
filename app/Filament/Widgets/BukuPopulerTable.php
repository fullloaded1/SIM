<?php

namespace App\Filament\Widgets;

use App\Models\Buku;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class BukuPopulerTable extends BaseWidget
{
    protected static ?int $sort = 3; // Nangkring di bawah tabel transaksi
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Koleksi Buku Terpopuler (Sering Dipinjam)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // ⚡ SINKRONISASI DATABASE: Mengubah relasi peminjaman menjadi detailPeminjaman
                Buku::query()
                    ->withCount('detailPeminjaman')
                    ->orderBy('detail_peminjaman_count', 'desc')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('penulis.nama_penulis')
                    ->label('Penulis')
                    ->badge()
                    ->color('info'),

                // ⚡ SINKRONISASI DATABASE: Mengubah peminjaman_count menjadi detail_peminjaman_count
                TextColumn::make('detail_peminjaman_count')
                    ->label('Total Dipinjam')
                    ->badge()
                    ->color('success')
                    ->suffix(' Kali')
                    ->sortable(),

                TextColumn::make('stok_tersedia')
                    ->label('Sisa Stok')
                    ->numeric()
                    ->sortable(),
            ]);
    }
}