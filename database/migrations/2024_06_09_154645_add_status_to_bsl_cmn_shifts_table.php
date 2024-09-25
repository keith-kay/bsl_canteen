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
        Schema::table('bsl_cmn_shifts', function (Blueprint $table) {
            $table->string('status')->after('bsl_cmn_shifts_mealsnumber')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bsl_cmn_shifts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
