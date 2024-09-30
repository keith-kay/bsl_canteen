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
            $table->string('bsl_cmn_users_days')->nullable(); // Add the new column and allow NULL values
        });
    }

    public function down()
    {
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            $table->dropColumn('bsl_cmn_users_days'); // Drop the column if the migration is rolled back
        });
    }
};
