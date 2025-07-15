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
        Schema::create('rekening_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank', 150);
            $table->string('nama_pemilik', 150);
            $table->string('nomor_rekening', 100)->unique();
            $table->string('logo')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_pembayarans');
    }
};
