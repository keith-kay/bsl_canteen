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
        Schema::create('model_has_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedInteger('model_id'); // Changed column name
            $table->timestamps();
            // Define foreign key constraints
            $table->foreign('model_id')->references('bsl_cmn_users_id')->on('bsl_cmn_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_shifts');
    }
};
