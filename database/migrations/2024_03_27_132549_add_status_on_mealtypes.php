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
        Schema::table('bsl_cmn_mealtypes', function (Blueprint $table) {
            // Add a new column
            $table->integer('bsl_cmn_mealtypes_status')->nullable()->after('bsl_cmn_mealtypes_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bsl_cmn_users', function (Blueprint $table) {
            // Add a new column
            $table->dropColumn('bsl_cmn_users_status');
        });
    }
};
