<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('meeting_room_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_sewa');
            $table->date('tanggal_selesai')->nullable(); // hanya diisi oleh admin
            $table->enum('status', ['disewa', 'dikembalikan'])->default('disewa');
            $table->integer('denda')->default(0); // jika lebih dari 5 hari
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rentals');
    }
};