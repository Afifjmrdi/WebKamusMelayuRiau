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
        Schema::create('pengajuan_kosakatas', function (Blueprint $table) {
            $table->id();
            $table->string('kata');
            $table->string('asal_kamus')->nullable();
            $table->string('kelas_kata');
            $table->text('arti');
            $table->text('contoh')->nullable();
            $table->string('asal_pengaju');
            $table->string('email_pengaju')->nullable();
            $table->text('alasan_pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kosakatas');
    }
};
