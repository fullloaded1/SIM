<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';
    
    // Menggunakan auto-increment sesuai skema SQL: id INT AUTO_INCREMENT
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}