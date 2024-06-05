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
            /* $table->unsignedBigInteger('bsl_cmn_sites_ip')->nullable();
            $table->foreign('bsl_cmn_sites_ip')
                ->references('bsl_cmn_IPs_id')
                ->on('bsl_cmn_IPs')
                ->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bsl_cmn_sites', function (Blueprint $table) {
            $table->dropForeign(['bsl_cmn_sites_ip']);
            $table->dropColumn('bsl_cmn_sites_ip');
        });
    }
};
