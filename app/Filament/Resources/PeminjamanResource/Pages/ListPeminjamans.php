<?php

namespace App\Filament\Resources\PeminjamanResource\Pages;

use App\Filament\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use App\Models\Peminjaman;

class ListPeminjamans extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Unduh Laporan Sirkulasi')
                ->button()
                ->color('info')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function(){
                    return response()->streamDownload(function() {
                        echo "ID Pinjam,Anggota,Buku,Tanggal Pinjam,Status\n";
                        
                        // Memuat data relasi secara aman
                        foreach (Peminjaman::with(['anggota','buku'])->get() as $p) {
                            $namaAnggota = $p->anggota?->nama_anggota ?? $p->anggota?->nama ?? 'Umum';
                            $judulBuku = $p->buku?->judul ?? 'Buku Dihapus';
                            $tglPinjam = $p->tgl_pinjam ? $p->tgl_pinjam->format('Y-m-d') : '-';
                            
                            echo "{$p->id_pinjam},{$namaAnggota},{$judulBuku},{$tglPinjam},{$p->status}\n";
                        }
                    }, 'laporan-sirkulasi-' . date('Y-m-d') . '.csv');
                })
        ];
    }
}