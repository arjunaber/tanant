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
        // First, update any units with 'pending' status to 'available'
        DB::table('units')->where('status', 'pending')->update(['status' => 'available']);

        // Remove 'pending' from the enum
        Schema::table('units', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->enum('status', ['available', 'pending', 'occupied', 'maintenance'])->default('available')->change();
        });
    }
};
