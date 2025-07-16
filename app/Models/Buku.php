<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kategori_buku_id',
        'judul',
        'slug',
        'penulis',
        'penerbit',
        'gambar_cover',
        'deskripsi',
        'tahun_terbit',
        'jumlah_halaman',
        'harga',
        'stok',
        'min_stok',
        'status',
    ];

    /**
     * Get the kategoriBuku that owns the Buku
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategoriBuku(): BelongsTo
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_buku_id', 'id');
    }

    /**
     * Get all barang masuk for this buku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangMasuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class);
    }

    /**
     * Get all mutasi barang for this buku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mutasiBarangs(): HasMany
    {
        return $this->hasMany(MutasiBarang::class);
    }

    /**
     * Check if stok is below minimum
     */
    public function isBelowMinimumStock(): bool
    {
        return $this->stok <= $this->min_stok;
    }

    /**
     * Get total barang masuk
     */
    public function getTotalBarangMasukAttribute(): int
    {
        return $this->barangMasuks()->approved()->sum('jumlah');
    }

    /**
     * Get total penjualan
     */
    public function getTotalPenjualanAttribute(): int
    {
        return $this->mutasiBarangs()->keluar()->sum('jumlah');
    }
}
