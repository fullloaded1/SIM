<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_pinjam');
            
            // Foreign Key ke tabel anggota dan buku
            $table->foreignId('id_anggota')
                ->constrained('anggota', 'id_anggota')
                ->cascadeOnDelete();
                
            $table->foreignId('id_buku')
                ->constrained('buku', 'id_buku')
                ->cascadeOnDelete();

            $table->date('tgl_pinjam');
            $table->date('tgl_jatuh_tempo');
            $table->date('tgl_kembali')->nullable();
            
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};