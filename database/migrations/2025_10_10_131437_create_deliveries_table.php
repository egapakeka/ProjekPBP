// database/migrations/2025_10_10_000000_create_deliveries_table.php

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('kurir')->nullable();
            $table->string('no_resi')->nullable();
            $table->enum('status_pengiriman', ['diproses', 'dikirim', 'selesai', 'batal'])->default('diproses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
