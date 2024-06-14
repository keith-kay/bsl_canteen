<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bsl_cmn_user_types')->insert([
            ['bsl_cmn_user_types_name'=>'Visitor'],
            ['bsl_cmn_user_types_name'=>'Contractor'],
            ['bsl_cmn_user_types_name'=>'Staff'],
            ['bsl_cmn_user_types_name'=>'Logistics'],
            ['bsl_cmn_user_types_name'=>'BSL'],
        ]);

    }
}
