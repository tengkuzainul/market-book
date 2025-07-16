<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MutasiBarang extends Model
{
    protected $fillable = [
        'kode_mutasi',
        'buku_id',
        'jenis_mutasi',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'referensi_tipe',
        'referensi_id',
        'user_id'
    ];

    /**
     * Generate kode mutasi otomatis
     */
    public static function generateKodeMutasi()
    {
        $date = now()->format('Ymd');
        $lastRecord = self::whereDate('created_at', now())->latest()->first();
        $sequence = $lastRecord ? (int)substr($lastRecord->kode_mutasi, -4) + 1 : 1;

        return 'MT' . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship dengan Buku
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Relationship dengan User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship polymorphic dengan referensi
     */
    public function referensi(): MorphTo
    {
        return $this->morphTo('referensi', 'referensi_tipe', 'referensi_id');
    }

    /**
     * Scope untuk jenis mutasi masuk
     */
    public function scopeMasuk($query)
    {
        return $query->where('jenis_mutasi', 'masuk');
    }

    /**
     * Scope untuk jenis mutasi keluar
     */
    public function scopeKeluar($query)
    {
        return $query->where('jenis_mutasi', 'keluar');
    }

    /**
     * Scope untuk jenis mutasi retur
     */
    public function scopeRetur($query)
    {
        return $query->where('jenis_mutasi', 'retur');
    }

    /**
     * Static method untuk mencatat mutasi
     */
    public static function catatMutasi($bukuId, $jenisMutasi, $jumlah, $keterangan, $referensi, $userId)
    {
        $buku = Buku::find($bukuId);
        $stokSebelum = $buku->stok;

        // Hitung stok sesudah berdasarkan jenis mutasi
        $stokSesudah = $stokSebelum;
        if ($jenisMutasi === 'masuk' || $jenisMutasi === 'retur') {
            $stokSesudah += $jumlah;
        } elseif ($jenisMutasi === 'keluar') {
            $stokSesudah -= $jumlah;
        }

        // Buat record mutasi
        $mutasi = self::create([
            'kode_mutasi' => self::generateKodeMutasi(),
            'buku_id' => $bukuId,
            'jenis_mutasi' => $jenisMutasi,
            'jumlah' => $jumlah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'keterangan' => $keterangan,
            'referensi_tipe' => get_class($referensi),
            'referensi_id' => $referensi->id,
            'user_id' => $userId
        ]);

        // Update stok buku
        $buku->update(['stok' => $stokSesudah]);

        return $mutasi;
    }
}
