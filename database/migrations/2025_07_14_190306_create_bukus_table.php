<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_buku_id')->constrained('kategori_bukus')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul', 255);
            $table->string('slug', 255);
            $table->string('penulis');
            $table->string('penerbit');
            $table->string('gambar_cover')->nullable();
            $table->text('deskripsi')->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->integer('min_stok')->default(0);
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
