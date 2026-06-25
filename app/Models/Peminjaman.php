<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    
    // ⚡ SINKRONISASI DATABASE: Ubah Primary Key sesuai skema .sql
    protected $primaryKey = 'id_peminjaman';
    
    // ⚡ SINKRONISASI DATABASE: Matikan auto-increment karena berupa VARCHAR(15)
    public $incrementing = false;
    protected $keyType = 'string';

    // ⚡ SINKRONISASI DATABASE: Sesuaikan kolom fillable dengan skema asli database perpus
    protected $fillable = [
        'id_peminjaman',
        'id_anggota',
        'id_petugas',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_kembali_aktual',
        'status',
        'denda'
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali' => 'date',
        'tgl_kembali_aktual' => 'date',
        'denda' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel Anggota (Many-to-One)
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Relasi ke tabel Petugas (Many-to-One)
     */
    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }

    /**
     * Relasi ke tabel Detail Peminjaman (One-to-Many)
     * Karena skema database kamu memisahkan item buku ke tabel detail_peminjaman
     */
    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}