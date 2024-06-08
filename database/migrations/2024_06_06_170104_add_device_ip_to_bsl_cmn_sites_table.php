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
        Schema::table('bsl_cmn_sites', function (Blueprint $table) {
            $table->string('bsl_cmn_sites_device_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bsl_cmn_sites', function (Blueprint $table) {
            $table->dropColumn('bsl_cmn_sites_device_ip');
        });
    }
};
