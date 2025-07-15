<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningPembayaran extends Model
{
    protected $table = 'rekening_pembayarans';

    protected $fillable = [
        'nama_bank',
        'nama_pemilik',
        'nomor_rekening',
        'logo',
        'status',
    ];
}
