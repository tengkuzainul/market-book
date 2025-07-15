<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBuku extends Model
{
    protected $table = 'kategori_bukus';

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

    /**
     * Get all of the bukus for the KategoriBuku
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bukus(): HasMany
    {
        return $this->hasMany(Buku::class, 'kategori_buku_id', 'id');
    }
}
