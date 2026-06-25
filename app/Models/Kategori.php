<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';
    
    // ⚡ SINKRONISASI DATABASE: Set Primary Key ke 'id_kategori' sesuai .sql asli
    protected $primaryKey = 'id_kategori';
    
    // ⚡ SINKRONISASI DATABASE: Matikan auto-increment karena berupa VARCHAR(10)
    public $incrementing = false;
    protected $keyType = 'string';

    // ⚡ SINKRONISASI DATABASE: Sesuaikan kolom fillable dengan skema tabel kategori
    protected $fillable = [
        'id_kategori',
        'nama_kategori',
        'deskripsi'
    ];

    /**
     * Relasi ke model Buku (One-to-Many)
     * Satu kategori bisa memiliki banyak koleksi buku
     */
    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class, 'id_kategori', 'id_kategori');
    }
}