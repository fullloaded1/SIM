<?php

namespace App\Filament\Resources\PenulisResource\Pages;

use App\Filament\Resources\PenulisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

// app/Filament/Resources/PenulisResource/Pages/ListPenulises.php

class ListPenulises extends ListRecords // <--- PASTIKAN TULISANNYA ListPenulises
{
    protected static string $resource = PenulisResource::class;
    // ... isi selebihnya biarkan sama
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
