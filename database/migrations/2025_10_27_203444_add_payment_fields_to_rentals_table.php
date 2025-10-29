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
            $table->string('transaction_id')->nullable()->after('processed_by');
            $table->string('payment_status')->default('pending')->after('transaction_id');
            $table->string('payment_url')->nullable()->after('payment_status');
            $table->json('payment_data')->nullable()->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'payment_status', 'payment_url', 'payment_data']);
        });
    }
};
