<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('printers')->insert([
            'site_id' => 1,
            'name' => 'Printer 1',
            #'address' => '127.0.0.1',
            'address' => '172.16.41.124',
            'port' => 9100,
            'status' => 1,
            'created_at'=>now()
        ]);
    }
}
