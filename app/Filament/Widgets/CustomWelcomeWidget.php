<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomWelcomeWidget extends Widget
{
    protected static ?int $sort = 1; // Kunci urutan nomor 1 paling atas
    protected int | string | array $columnSpan = 'full'; // Lebar penuh
    protected static string $view = 'filament.widgets.custom-welcome-widget';
}