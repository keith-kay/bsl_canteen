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
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            // Add the new column for the foreign key
            $table->unsignedBigInteger('bsl_cmn_users_shift')->nullable();

            // Add the foreign key constraint
            $table->foreign('bsl_cmn_users_shift')
                ->references('bsl_cmn_shifts_id')
                ->on('bsl_cmn_shifts')
                ->onDelete('set null'); // Set to null on delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['bsl_cmn_users_shift']);

            // Drop the column
            $table->dropColumn('bsl_cmn_users_shift');
        });
    }
};
