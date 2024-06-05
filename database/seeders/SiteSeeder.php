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
            'bsl_cmn_sites_name' => 'Dev Canteen',
            'bsl_cmn_sites_status' => 1,
            'bsl_cmn_sites_device_ip' => "127.0.0.1",
            'created_at'=>now()
        ]);
    }
}
