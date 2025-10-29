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
        Schema::table('rentals', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'completed', 'overdue', 'cancelled'])->default('pending')->change();
        });

        // Update units table to include 'pending' status
        Schema::table('units', function (Blueprint $table) {
            $table->enum('status', ['available', 'pending', 'occupied', 'maintenance'])->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->enum('status', ['active', 'completed', 'overdue', 'cancelled'])->default('active')->change();
        });

        // Revert units table status
        Schema::table('units', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available')->change();
        });
    }
};
