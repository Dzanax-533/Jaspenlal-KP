<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('surat_permohonan')->nullable();
            $table->string('formulir_pendaftaran')->nullable();
            $table->string('nib')->nullable();
            $table->string('penyelia_halal')->nullable();
            $table->string('fasilitas_pabrik')->nullable();
            $table->string('daftar_produk')->nullable();
            $table->string('daftar_bahan')->nullable();
            $table->string('diagram_alir')->nullable();
            $table->string('manual_sjh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
