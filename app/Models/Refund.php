<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Get the user that owns the refund
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all mutasi barang for this refund
     */
    public function mutasiBarangs(): MorphMany
    {
        return $this->morphMany(MutasiBarang::class, 'referensi', 'referensi_tipe', 'referensi_id');
    }
}
