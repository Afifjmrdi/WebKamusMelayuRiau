<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordResetColumnsToAdminsTable extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('reset_token')->nullable()->after('password');
            $table->timestamp('reset_expires_at')->nullable()->after('reset_token');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['reset_token', 'reset_expires_at']);
        });
    }
}
