<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $fillable = [
        'pesanan_id',
        'buku_id',
        'judul_buku',
        'harga',
        'jumlah',
        'subtotal'
    ];

    /**
     * Get the order that owns the item
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Get the book that is in the order
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
