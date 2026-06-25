<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penulis;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Anggota;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Seeder Dummy Data Master
        for ($i = 1; $i <= 10; $i++) {
            Penulis::create([
                'nama_penulis' => "Penulis Hebat ke-$i",
                'kebangsaan' => $i % 2 == 0 ? 'Indonesia' : 'Jepang'
            ]);

            Kategori::create([
                'nama_kategori' => "Kategori Buku $i",
                'deskripsi' => "Deskripsi ilmiah untuk kategori nomor $i"
            ]);

            Anggota::create([
                'nama' => "Anggota Perpus $i",
                'email' => "anggota$i@perpustakaan.com",
                'no_hp' => "0812345678$i",
                'alamat' => "Jl. Pemuda Merdeka No. $i, Kota Depok",
                'status_aktif' => true
            ]);
        }

        // Hubungkan Buku dengan Kategori & Penulis
        for ($j = 1; $j <= 10; $j++) {
            $buku = Buku::create([
                'isbn' => "978-602-032-45$j-" . rand(0,9),
                'judul' => "Mastering Laravel & Filament Vol. $j",
                'id_penulis' => rand(1, 10),
                'tahun_terbit' => 2020 + $j,
                'stok_total' => 5,
                'stok_tersedia' => 5,
                'sinopsis' => "Buku referensi terlengkap bab ke-$j mengenai arsitektur sistem informasi modern."
            ]);
            
            $buku->kategori()->attach([rand(1,5), rand(6,10)]);
        }
    }
}