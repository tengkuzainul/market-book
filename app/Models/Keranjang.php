<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = [
        'user_id',
        'buku_id',
        'jumlah'
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is in the cart
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Calculate subtotal for this cart item
     */
    public function getSubtotalAttribute()
    {
        return $this->buku->harga * $this->jumlah;
    }
}
