<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penulis', function (Blueprint $table) {
            $table->id('id_penulis');
            $table->string('nama_penulis', 150);
            $table->string('kebangsaan', 100)->default('Indonesia');
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('anggota', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('nama', 150);
            $table->string('email', 100)->unique();
            $table->string('no_hp', 20);
            $table->text('alamat');
            $table->date('tgl_daftar')->useCurrent();
            $table->boolean('status_aktif')->default(true);
            $table->string('foto_profil')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('isbn', 20)->unique();
            $table->string('judul', 255);
            $table->foreignId('id_penulis')->nullable()->constrained('penulis', 'id_penulis')->onDelete('set null')->onUpdate('cascade');
            $table->year('tahun_terbit');
            $table->integer('stok_total')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->string('gambar_sampul')->nullable();
            $table->text('sinopsis')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabel Pivot Many-to-Many Buku <-> Kategori
        Schema::create('buku_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->onDelete('cascade');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori')->onDelete('cascade');
        });

        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjam');
            $table->foreignId('id_anggota')->constrained('anggota', 'id_anggota')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_user_petugas')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->date('tgl_pinjam')->useCurrent();
            $table->date('tgl_jatuh_tempo');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
            $table->timestamps();
        });

        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id('id_kembali');
            $table->foreignId('id_pinjam')->constrained('peminjaman', 'id_pinjam')->onDelete('restrict')->onUpdate('cascade');
            $table->date('tgl_kembali')->useCurrent();
            $table->enum('kondisi_buku', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->decimal('denda', 10, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->foreignId('id_kembali')->constrained('pengembalian', 'id_kembali')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('jumlah_denda', 10, 2);
            $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->date('tgl_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
{
    // Hapus tabel yang memiliki Foreign Key terlebih dahulu (Child Tables)
    Schema::dropIfExists('denda');
    Schema::dropIfExists('pengembalian');
    Schema::dropIfExists('peminjaman');
    Schema::dropIfExists('buku_kategori');
    
    // Baru hapus tabel utama (Parent Tables)
    Schema::dropIfExists('buku');
    Schema::dropIfExists('anggota');
    Schema::dropIfExists('kategori');
    Schema::dropIfExists('penulis');
}
};