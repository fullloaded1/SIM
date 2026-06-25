<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    // ⚡ FIX DATABASE: Hapus SoftDeletes karena di skema SQL asli tidak menggunakan fitur hapus data sementara
    
    protected $table = 'anggota';
    
    // ⚡ FIX DATABASE: Set Primary Key ke 'id_anggota'
    protected $primaryKey = 'id_anggota';
    
    // ⚡ FIX DATABASE: Karena Primary Key bertipe VARCHAR(15), matikan auto-increment agar Laravel tidak memaksanya jadi integer
    public $incrementing = false;
    protected $keyType = 'string';

    // ⚡ FIX DATABASE: Sesuaikan isi array fillable agar akurat dengan kolom di file .sql kamu
    protected $fillable = [
        'id_anggota', 
        'nama', 
        'alamat', 
        'no_telp', 
        'email', 
        'tgl_daftar', 
        'status'
    ];
    
    protected $casts = [
        'tgl_daftar' => 'date',
    ];

    /**
     * Relasi ke tabel peminjaman (1 Anggota bisa punya banyak transaksi Peminjaman)
     */
    public function peminjaman(): HasMany
    {
        // Parameter ke-2 adalah foreign key di tabel peminjaman, parameter ke-3 adalah local key di tabel anggota
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }
}