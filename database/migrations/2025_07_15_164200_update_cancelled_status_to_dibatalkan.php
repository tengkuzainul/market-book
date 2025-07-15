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
                    // Update all orders with 'cancelled' status to 'dibatalkan'
                    Pesanan::where('status', 'cancelled')->update(['status' => 'dibatalkan']);
          }

          /**
           * Reverse the migrations.
           */
          public function down(): void
          {
                    // No need to revert - we're standardizing on 'dibatalkan'
          }
};
