<?php

namespace App\Models;

// ⚡ IMPORT KELAS UTAMA AUTENTIKASI
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Authenticatable // ⚡ UBAH EXTENDS-NYA KE SINI
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_petugas',
        'nama',
        'username',
        'password',
        'no_telp'
    ];

    // Kolom pengganti email bawaan Laravel karena di tabelmu menggunakan 'username'
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}