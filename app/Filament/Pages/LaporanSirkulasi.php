<?php

namespace App\Filament\Pages;

use App\Models\Peminjaman;
use Filament\Pages\Page;
use Livewire\Attributes\Url;

class LaporanSirkulasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = 'Transaksi Sirkulasi';
    protected static ?string $navigationLabel = 'Laporan Sirkulasi';
    protected static ?string $title = 'Laporan Sirkulasi Perpustakaan';

    protected static string $view = 'filament.pages.laporan-sirkulasi';

    #[Url]
    public ?string $tgl_mulai = null;

    #[Url]
    public ?string $tgl_selesai = null;

    public function mount(): void
    {
        // Default set ke awal bulan ini sampai hari ini
        $this->tgl_mulai ??= now()->startOfMonth()->format('Y-m-d');
        $this->tgl_selesai ??= now()->format('Y-m-d');
    }

    public function getReportDataProperty()
    {
        return Peminjaman::query()
            ->whereBetween('tgl_pinjam', [$this->tgl_mulai, $this->tgl_selesai])
            ->with(['anggota', 'buku'])
            ->latest('tgl_pinjam')
            ->get();
    }

    public function getStatsProperty()
    {
        $data = $this->report_data;
        return [
            'total' => $data->count(),
            'dipinjam' => $data->where('status', 'dipinjam')->count(),
            'kembali' => $data->where('status', 'dikembalikan')->count(),
        ];
    }
}