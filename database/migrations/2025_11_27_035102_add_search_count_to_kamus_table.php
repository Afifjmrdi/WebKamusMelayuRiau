<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kamus', function (Blueprint $table) {
            $table->unsignedBigInteger('search_count')->default(0)->after('contoh');
        });
    }

    public function down()
    {
        Schema::table('kamus', function (Blueprint $table) {
            $table->dropColumn('search_count');
        });
    }
};
