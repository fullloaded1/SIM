<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Penulis extends Model
{
    protected $table = 'penulis';
    protected $primaryKey = 'id_penulis';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_penulis', 
        'nama_penulis', 
        'biografi'
    ];

    public function buku(): BelongsToMany
    {
        return $this->belongsToMany(
            Buku::class, 
            'buku_penulis', // Nama tabel jembatan di database kamu
            'id_penulis',   // Foreign key tabel penulis di tabel jembatan
            'id_buku'       // Foreign key tabel buku di tabel jembatan
        );
    }
}