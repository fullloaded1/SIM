<?php

namespace App\Filament\Widgets;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Biar nangkring di urutan paling atas

    protected function getStats(): array
    {
        // 1. Hitung buku yang belum dikembalikan (Status masih 'dipinjam')
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // 2. ⚡ SINKRONISASI DATABASE: Mengubah tgl_jatuh_tempo menjadi tgl_kembali sesuai skema .sql asli
        $bukuTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tgl_kembali', '<', Carbon::today()) // Membandingkan batas tanggal kembali dengan hari ini
            ->count();

        // 3. Ambil data hitungan total anggota langsung dari model Anggota yang sudah bugar
        $totalAnggota = Anggota::count();

        return [
            Stat::make('Total Koleksi Buku', Buku::count() . ' Judul')
                ->description('Semua buku terdaftar')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info'),

            Stat::make('Buku Sedang Dipinjam', $bukuDipinjam . ' Transaksi')
                ->description('Aktif di luar perpustakaan')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),

            Stat::make('Peminjaman Terlambat', $bukuTerlambat . ' Buku')
                ->description($bukuTerlambat > 0 ? 'Ada yang telat balikin!' : 'Aman, tidak ada tunggakan')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($bukuTerlambat > 0 ? 'danger' : 'success'),

            Stat::make('Total Anggota Aktif', $totalAnggota . ' Orang')
                ->description('Anggota terdaftar di sistem')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}