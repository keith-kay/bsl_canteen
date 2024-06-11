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
            // Add the new column for the shift
            $table->string('bsl_cmn_logs_shift')->nullable();
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
            // Drop the column
            $table->dropColumn('bsl_cmn_logs_shift');
        });
    }
};
