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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained()->onDelete('cascade');
            $table->enum('termin', ['1', '2'])->default('1');
            $table->string('bukti_transfer');
            $table->decimal('nominal', 15, 2); // Ubah jumlah_bayar jadi nominal agar cocok dengan Controller
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending'); // Gunakan nama ini
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
