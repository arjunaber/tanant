<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // ... (use statements)

    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unit')->unique();
            $table->string('nama_unit');
            $table->text('deskripsi')->nullable();

            // Status ketersediaan unit
            $table->enum('status', ['available', 'borrowed', 'maintenance'])
                ->default('available');

            $table->string('lokasi')->nullable();
            $table->integer('kapasitas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
