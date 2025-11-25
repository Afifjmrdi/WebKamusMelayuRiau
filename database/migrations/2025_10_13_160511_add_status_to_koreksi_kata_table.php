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
        Schema::table('koreksi_kata', function (Blueprint $table) {
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('koreksi_kata', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

};
