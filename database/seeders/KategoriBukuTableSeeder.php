<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriBukuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Buku Pelajaran',
            'Buku Novel',
            'Buku Sejarah',
            'Buku Pengetahuan Umum',
            'Buku Agama',
        ];

        foreach ($data as $value) {
            KategoriBuku::create([
                'nama_kategori' => $value,
                'slug' => Str::slug($value),
            ]);
        }
    }
}
