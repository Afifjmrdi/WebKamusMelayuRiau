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
        Schema::create('kamus_istilah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_entri')->nullable();
            $table->string('bahasa_daerah')->nullable();
            $table->string('sumber')->nullable();
            $table->string('entri');
            $table->string('jenis')->nullable();
            $table->string('lafal')->nullable();
            $table->string('kelas_kata')->nullable();
            $table->string('label_bahasa')->nullable();
            $table->text('makna_entri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamus_istilahs');
    }
};
