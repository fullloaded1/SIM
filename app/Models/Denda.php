<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    protected $fillable = ['id_kembali', 'jumlah_denda', 'status_bayar', 'tgl_bayar'];

    protected $casts = [
        'tgl_bayar' => 'date',
    ];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(Pengembalian::class, 'id_kembali', 'id_kembali');
    }
}