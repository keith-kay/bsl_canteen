<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bsl_cmn_logs', function (Blueprint $table) {
            $table->increments('bsl_cmn_logs_id');
            $table->integer('bsl_cmn_logs_person')->unsigned();
            $table->foreign('bsl_cmn_logs_person')->references('bsl_cmn_users_id')->on('bsl_cmn_users');
            $table->integer('bsl_cmn_logs_mealtype')->unsigned();
            $table->foreign('bsl_cmn_logs_mealtype')->references('bsl_cmn_mealtypes_id')->on('bsl_cmn_mealtypes');
            $table->timestamp('bsl_cmn_logs_time');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsl_cmn_logs');
    }
};
