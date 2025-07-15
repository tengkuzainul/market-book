<?php

use App\Models\Pesanan;
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
        // Update all orders with dibatalkan status to cancelled
        Pesanan::where('status', 'dibatalkan')->update(['status' => 'cancelled']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to dibatalkan
        Pesanan::where('status', 'cancelled')->update(['status' => 'dibatalkan']);
    }
};
