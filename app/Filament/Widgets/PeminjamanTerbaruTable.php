<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class PeminjamanTerbaruTable extends BaseWidget
{
    // Mengatur urutan agar tabel ini nangkring tepat di bawah Kotak Statistik Utama
    protected static ?int $sort = 2;

    // Memaksa lebar tabel memanjang penuh 100% dari kiri ke kanan dashboard
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Daftar Peminjaman Buku Terbaru (Aktif)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Peminjaman::query()
                    ->where('status', 'dipinjam')
                    ->latest('created_at')
                    ->limit(5)
            )
            ->columns([
                // ⚡ FIX: Sesuaikan dari 'anggota.nama_anggota' menjadi 'anggota.nama' agar namanya langsung muncul!
                TextColumn::make('anggota.nama')
                    ->label('Nama Anggota')
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-user'),

                TextColumn::make('buku.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('tgl_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date('d M Y')
                    ->color('gray'),

                TextColumn::make('tgl_jatuh_tempo')
                    ->label('Batas Kembali')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->tgl_jatuh_tempo < now() ? 'danger' : 'warning')
                    ->weight('semibold'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->actions([
                Tables\Actions\Action::make('cek_transaksi')
                    ->label('Cek')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->url(fn (Peminjaman $record) => url("/admin/peminjamans/{$record->id_pinjam}/edit")),
            ]);
    }
}