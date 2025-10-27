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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            // Relasi ke siapa yang meminjam
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke unit apa yang dipinjam
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');

            // Admin yang memproses pengembalian (sesuai req)
            $table->foreignId('returned_by_admin_id')->nullable()
                ->constrained('users')->onDelete('set null');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali'); // Tanggal rencana kembali
            $table->date('tanggal_pengembalian_aktual')->nullable(); // Tanggal aktual kembali

            // Status peminjaman saat ini
            $table->enum('status', ['active', 'completed', 'overdue'])
                ->default('active');

            // Denda (jika lebih dari 5 hari)
            $table->decimal('denda', 10, 2)->nullable()->default(0);

            $table->text('catatan_admin')->nullable(); // Catatan saat pengembalian

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
