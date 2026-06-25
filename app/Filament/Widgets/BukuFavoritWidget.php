<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Buku;
use App\Models\Kategori;

class BukuFavoritWidget extends Widget
{
    // Mengatur lebar widget agar penuh 1 kolom (menggantikan posisi chart lama)
    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.buku-favorit-widget';

    /**
     * Mengirimkan data riil database ke view blade widget
     */
    protected function getViewData(): array
{
    return [
        'bukuFavorit' => \App\Models\Buku::with(['kategori', 'penulis'])
            ->withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc') 
            ->orderBy('id_buku', 'desc') // ⚡ KUNCI UTAMA: Buku baru gres langsung ikut naik ke atas dashboard
            ->limit(30)
            ->get(),

        'genres' => \App\Models\Kategori::all(),
    ];
}
    }
