<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    // ⚡ Mengubah judul halaman saat dikunjungi kembali ke standar Filament
    protected static ?string $title = 'Dashboard';

    // ⚡ SOLUSI UTAMA: Mengubah label di menu samping agar menyatu dengan dashboard bawaan asli
    protected static ?string $navigationLabel = 'Dashboard';

    /**
     * Kita kosongkan return-nya agar tidak merender ganda komponen header yang sama
     */
    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return null; 
    }
}