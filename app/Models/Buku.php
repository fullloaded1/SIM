<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'buku';
    
    // ⚡ SINKRONISASI DATABASE: Set Primary Key ke 'id_buku'
    protected $primaryKey = 'id_buku';
    
    // ⚡ SINKRONISASI DATABASE: Matikan auto-increment karena berupa VARCHAR(15)
    public $incrementing = false;
    protected $keyType = 'string';

    // ⚡ SINKRONISASI DATABASE: Ditambahkan 'foto_buku' ke dalam fillable agar bisa tersimpan bugar ke MySQL
    protected $fillable = [
        'id_buku',
        'judul',
        'foto_buku', // ⚡ WAJIB MASUK: Lapangan tampung file cover buku
        'id_kategori',
        'penerbit',
        'tahun_terbit',
        'stok',
        'stok_tersedia'
    ];

    // ⚡ SINKRONISASI CASCADE DELETE: Otomatis membersihkan anak data di detail_peminjaman sebelum buku induknya dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($buku) {
            // Memastikan data detail peminjaman yang terikat ikut terhapus otomatis agar terhindar dari eror Constraint 1451
            $buku->detailPeminjaman()->delete();
        });
    }

    /**
     * Relasi ke model Kategori (Many-to-One)
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi Banyak-ke-Banyak (M:N) ke model Penulis melalui tabel jembatan buku_penulis
     */
    public function penulis(): BelongsToMany
    {
        return $this->belongsToMany(
            Penulis::class,
            'buku_penulis', // Nama tabel jembatan
            'id_buku',       // FK tabel buku di tabel jembatan
            'id_penulis'     // FK tabel penulis di tabel jembatan
        );
    }

    /**
     * Relasi ke Detail Peminjaman (One-to-Many)
     */
    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_buku', 'id_buku');
    }
}