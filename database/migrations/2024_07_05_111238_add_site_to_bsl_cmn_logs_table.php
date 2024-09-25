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
            $table->unsignedInteger('bsl_cmn_logs_site')->nullable();

            $table->foreign('bsl_cmn_logs_site')
                ->references('bsl_cmn_sites_id')
                ->on('bsl_cmn_sites')
                ->onDelete('cascade');
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
            $table->dropForeign(['bsl_cmn_logs_site']);
            $table->dropColumn('bsl_cmn_logs_site');
        });
    }
};