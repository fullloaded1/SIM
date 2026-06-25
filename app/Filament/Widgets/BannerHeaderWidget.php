<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class BannerHeaderWidget extends Widget
{
    // Mengarah ke file blade slider kustom kamu (dashboard-header)
    protected static string $view = 'filament.components.dashboard-header';

    // Mengambil porsi 2 kolom dari total 3 kolom grid Filament
    protected int | string | array $columnSpan = 2;
    
    // Mengatur urutan agar berada di paling atas sebelum widget lainnya
    protected static ?int $sort = -3;
}