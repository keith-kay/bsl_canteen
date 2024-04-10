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
        Schema::table('bsl_cmn_logs', function (Blueprint $table) {
            $table->timestamp('bsl_cmn_logs_time')->nullable()->after('bsl_cmn_logs_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bsl_cmn_logs', function (Blueprint $table) {
            $table->dropColumn('bsl_cmn_logs_time');
        });
    }
};
