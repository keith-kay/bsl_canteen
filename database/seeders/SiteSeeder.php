<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bsl_cmn_sites')->insert([
            'bsl_cmn_sites_name' => 'Site 1',
            'bsl_cmn_sites_status' => 1,
            #'bsl_cmn_sites_ip' => "127.0.0.1",
            'bsl_cmn_sites_ip' => 127,
            'created_at'=>now()
        ]);
    }
}
