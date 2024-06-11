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
        Schema::create('bsl_cmn_shifts', function (Blueprint $table) {
            $table->id('bsl_cmn_shifts_id');
            $table->string('bsl_cmn_shifts_name');
            $table->time('bsl_cmn_shifts_starttime');
            $table->time('bsl_cmn_shifts_endtime');
            $table->integer('bsl_cmn_shifts_mealsnumber');
            $table->timestamps(); // This will create created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bsl_cmn_shifts');
    }
};
