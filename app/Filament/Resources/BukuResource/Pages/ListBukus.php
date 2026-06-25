<?php

namespace App\Filament\Resources\BukuResource\Pages;

use App\Filament\Resources\BukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListBukus extends ListRecords
{
    protected static string $resource = BukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New buku'),
        ];
    }

    /**
     * ⚡ KUNCI AMAN: Menggabungkan Filter Genre di atas tanpa merusak susunan Grid Kartu di bawah
     */
    public function getHeader(): ?View
    {
        return view('filament.pages.filter-genre-header', [
            'actions' => $this->getCachedHeaderActions(),
        ]);
    }
}