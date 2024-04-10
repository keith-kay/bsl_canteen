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
            // Add back the bsl_cmn_logs_time column
            $table->timestamp('bsl_cmn_logs_time')->nullable()->after('bsl_cmn_logs_person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bsl_cmn_logs', function (Blueprint $table) {
            // Drop the bsl_cmn_logs_time column
            $table->dropColumn('bsl_cmn_logs_time');
        });
    }
};
