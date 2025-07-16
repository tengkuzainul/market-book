<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BarangMasuk extends Model
{
    protected $fillable = [
        'kode_barang_masuk',
        'buku_id',
        'jumlah',
        'harga_beli',
        'total_harga',
        'supplier',
        'keterangan',
        'tanggal_masuk',
        'status',
        'user_id',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'approved_at' => 'datetime',
        'harga_beli' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    /**
     * Generate kode barang masuk otomatis
     */
    public static function generateKodeBarangMasuk()
    {
        $date = now()->format('Ymd');
        $lastRecord = self::whereDate('created_at', now())->latest()->first();
        $sequence = $lastRecord ? (int)substr($lastRecord->kode_barang_masuk, -3) + 1 : 1;

        return 'BM' . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship dengan Buku
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Relationship dengan User (yang input)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship dengan User (yang approve)
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relationship dengan Mutasi Barang
     */
    public function mutasiBarangs(): MorphMany
    {
        return $this->morphMany(MutasiBarang::class, 'referensi', 'referensi_tipe', 'referensi_id');
    }

    /**
     * Scope untuk status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope untuk status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
