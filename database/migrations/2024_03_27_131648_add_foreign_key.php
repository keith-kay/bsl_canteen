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
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            // Add a foreign key column referencing the 'bsl_cmn_users' table
            $table->integer('bsl_cmn_users_type')->unsigned();
            $table->foreign('bsl_cmn_users_type')->references('bsl_cmn_user_types_id')->on('bsl_cmn_user_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            // Drop the foreign key column
            $table->dropForeign(['bsl_cmn_users_type']);
            $table->dropColumn('bsl_cmn_users_type');
        });
    }
};
