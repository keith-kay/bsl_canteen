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
        Schema::create('bsl_cmn_users', function (Blueprint $table) {
            $table->increments('bsl_cmn_users_id')->comment('bsl_cmn_users_id');
            $table->string('bsl_cmn_users_firstname');
            $table->string('bsl_cmn_users_lastname');
            $table->string('bsl_cmn_users_employment_number');
            $table->string('bsl_cmn_users_pin');
            $table->integer('bsl_cmn_users_status')->default(1);
            $table->string('password');
            $table->integer('bsl_cmn_users_type')->unsigned();
            $table->timestamps();
            ##$table->foreign('bsl_cmn_users_type')->references('bsl_cmn_user_types_id')->on('bsl_cmn_user_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsl_cmn_users');
    }
};