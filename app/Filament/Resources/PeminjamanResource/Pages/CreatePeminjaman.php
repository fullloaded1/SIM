<?php

namespace App\Filament\Resources\PeminjamanResource\Pages; // ⚡ PERBAIKAN: Namespace disesuaikan dengan foldernya

use App\Filament\Resources\PeminjamanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource = PeminjamanResource::class;

    /**
     * Mengarahkan halaman kembali ke daftar tabel peminjaman setelah sukses menambah data
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}