<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'pesanan_id',
        'user_id',
        'jumlah',
        'metode_refund',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'nama_bank',
        'status',
        'bukti_refund',
        'alasan_pembatalan',
        'catatan_admin'
    ];

    /**
     * Get the pesanan that owns the refund
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Get the user that owns the refund
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
