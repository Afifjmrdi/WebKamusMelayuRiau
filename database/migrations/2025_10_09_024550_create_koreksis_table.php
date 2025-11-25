<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('koreksi_kata', function (Blueprint $table) {
            $table->id();
            $table->string('asal_kamus');
            $table->string('kata');
            $table->string('suku_kata');
            $table->string('bagian_dikoreksi');
            $table->text('nilai_baru');
            $table->text('alasan')->nullable();
            $table->string('nama_pengoreksi');
            $table->string('email_pengoreksi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koreksis');
    }
};
