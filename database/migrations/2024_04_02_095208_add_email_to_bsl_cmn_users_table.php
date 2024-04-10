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
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            $table->string('bsl_cmn_users_email')->unique()->nullable()->after('bsl_cmn_users_pin');
        });
    }

    public function down()
    {
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            $table->dropColumn('bsl_cmn_users_email');
        });
    }
};
