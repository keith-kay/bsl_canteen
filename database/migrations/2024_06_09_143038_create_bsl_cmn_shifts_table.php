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
        Schema::create('user_has_shifts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_id');
            $table->timestamps();

            // Adjust foreign key references
            $table->foreign('user_id')->references('bsl_cmn_users_id')->on('bsl_cmn_users')->onDelete('cascade');
            $table->foreign('shift_id')->references('bsl_cmn_shifts_id')->on('bsl_cmn_shifts')->onDelete('cascade');

            $table->primary(['user_id', 'shift_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_shifts');
    }
};
