<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToKamusTable extends Migration
{
    public function up()
    {
        Schema::table('kamus', function (Blueprint $table) {
            // index biasa untuk LIKE (prefix/contain)
            $table->index('kata');
            $table->index('asal_kamus');
            $table->index('arti');
            // tambahan kolom untuk tracking popularitas
            $table->unsignedBigInteger('search_count')->default(0)->after('contoh');
        });
    }

    public function down()
    {
        Schema::table('kamus', function (Blueprint $table) {
            $table->dropIndex(['kata']);
            $table->dropIndex(['asal_kamus']);
            $table->dropIndex(['arti']);
           
        });
    }
}
