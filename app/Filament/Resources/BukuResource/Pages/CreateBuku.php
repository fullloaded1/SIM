<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBuku extends CreateRecord
{
    protected static string $resource = BukuResource::class;

    /**
     * ⚡ KUNCI UTAMA: Otomatis redirect ke halaman index katalog setelah berhasil create
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}