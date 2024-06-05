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
       /*  Schema::create('bsl_cmn_IPs', function (Blueprint $table) {
            $table->bigIncrements('bsl_cmn_IPs_id');
            $table->string('bsl_cmn_IPs_name');
            $table->string('bsl_cmn_IPs_address');
            $table->timestamps();
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsl_cmn_IPs');
    }
};
