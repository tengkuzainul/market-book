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
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mutasi')->unique();
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->enum('jenis_mutasi', ['masuk', 'keluar', 'retur']); // masuk=barang masuk, keluar=penjualan, retur=refund
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan');
            $table->string('referensi_tipe'); // App\Models\BarangMasuk, App\Models\Pesanan, App\Models\Refund
            $table->unsignedBigInteger('referensi_id'); // ID dari tabel referensi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Index untuk referensi polymorphic
            $table->index(['referensi_tipe', 'referensi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barangs');
    }
};
