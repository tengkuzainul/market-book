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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', 12, 2);
            $table->text('alamat_pengiriman');
            $table->foreignId('rekening_pembayaran_id')->nullable()->constrained('rekening_pembayarans')->nullOnDelete();
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['diproses', 'disetujui', 'dikemas', 'diantarkan', 'selesai', 'dibatalkan'])->default('diproses');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
