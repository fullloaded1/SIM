<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class PeminjamanChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Aktivitas Peminjaman Buku';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // 1. Ambil data peminjaman 6 bulan terakhir menggunakan query native Laravel
        $peminjamanPerBulan = Peminjaman::selectRaw('COUNT(*) as total, DATE_FORMAT(created_at, "%Y-%m") as bulan')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->pluck('total', 'bulan')
            ->toArray();

        // 2. Petakan data agar bulan yang kosong tetap muncul 0 (Biar grafik tidak patah)
        $chartData = [];
        $chartLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulanKey = now()->subMonths($i)->format('Y-m');
            $chartLabels[] = now()->subMonths($i)->translatedFormat('M Y');
            $chartData[] = $peminjamanPerBulan[$bulanKey] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Buku Dipinjam',
                    'data' => $chartData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 3,
                    'fill' => true,
                    'tension' => 0.3, // Efek melengkung smooth
                ],
            ],
            'labels' => $chartLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}