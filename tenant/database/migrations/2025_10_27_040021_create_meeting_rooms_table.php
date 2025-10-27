<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruangan')->unique(); // kode unik tiap ruangan
            $table->string('nama_ruangan')->required(); // nama bisa sama
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('meeting_rooms');
    }
};