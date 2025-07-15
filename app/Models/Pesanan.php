<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'kode_pesanan',
        'user_id',
        'total_harga',
        'alamat_pengiriman',
        'rekening_pembayaran_id',
        'bukti_pembayaran',
        'status',
        'catatan'
    ];

    /**
     * Get the user that made the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for this order
     */
    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }

    /**
     * Get the rekening pembayaran for this order
     */
    public function rekeningPembayaran()
    {
        return $this->belongsTo(RekeningPembayaran::class);
    }

    /**
     * Get the refund for this order
     */
    public function refund()
    {
        return $this->hasOne(Refund::class);
    }

    /**
     * Generate a unique order code
     */
    public static function generateKodePesanan()
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $randomString = strtoupper(substr(md5(uniqid()), 0, 5));

        return $prefix . $date . '-' . $randomString;
    }
}
