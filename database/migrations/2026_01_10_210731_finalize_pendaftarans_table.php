<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Memastikan progress_level mulai dari 0 (Level 0: Profil)
            $table->integer('progress_level')->default(0)->change();
            // Menambah kolom catatan evaluasi untuk konsultan (Opsional tapi penting)
            if (!Schema::hasColumn('pendaftarans', 'catatan_konsultan')) {
                $table->text('catatan_konsultan')->nullable();
            }
        });

        Schema::table('klien_details', function (Blueprint $table) {
            // Memastikan kolom skala_usaha konsisten
            $table->string('skala_usaha')->change();
        });
    }

    public function down() {}
};
