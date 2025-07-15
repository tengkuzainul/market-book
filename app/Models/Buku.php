<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
