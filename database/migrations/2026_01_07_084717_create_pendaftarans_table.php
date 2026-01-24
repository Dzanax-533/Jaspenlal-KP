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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('paket_id')->constrained();
            $table->string('no_pendaftaran')->unique();
            $table->integer('total_menu')->default(50); // Contoh: 80 menu
            $table->integer('total_outlet')->default(1); // Contoh: 2 outlet
            $table->boolean('luar_jabodetabek')->default(false); // Untuk catatan akomodasi
            $table->decimal('total_biaya', 15, 2)->nullable();
            $table->enum('status', ['pending', 'invoice', 'bayar_dp', 'lunas', 'proses', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
