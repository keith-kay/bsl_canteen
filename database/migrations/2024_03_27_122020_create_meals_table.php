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
        Schema::create('bsl_cmn_mealtypes', function (Blueprint $table) {
            $table->increments('bsl_cmn_mealtypes_id');
            $table->string('bsl_cmn_mealtypes_mealname');
            //$table->integer('bsl_cmn_mealtypes_site')->unsigned();
            //$table->foreign('bsl_cmn_mealtypes_site')->references('bsl_cmn_sites_id')->on('bsl_cmn_sites');
            $table->integer('bsl_cmn_mealtypes_numberofmeals');
            $table->integer('bsl_cmn_mealtypes_starthour');
            $table->integer('bsl_cmn_mealtypes_duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsl_cmn_mealtypes');
    }
};
