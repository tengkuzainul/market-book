<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(PesananItem::class);
    }

    /**
     * Get the rekening pembayaran for this order
     */
    public function rekeningPembayaran(): BelongsTo
    {
        return $this->belongsTo(RekeningPembayaran::class);
    }

    /**
     * Get the refund for this order
     */
    public function refund(): HasOne
    {
        return $this->hasOne(Refund::class);
    }

    /**
     * Get all mutasi barang for this order
     */
    public function mutasiBarangs(): MorphMany
    {
        return $this->morphMany(MutasiBarang::class, 'referensi', 'referensi_tipe', 'referensi_id');
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
