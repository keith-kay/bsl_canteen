<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bsl_cmn_shifts')->insert([
            [
                'bsl_cmn_shifts_name'=>'Normal Shift',
                'bsl_cmn_shifts_starttime'=>'07:00:00',
                'bsl_cmn_shifts_endtime'=>'06:59:59',
                'bsl_cmn_shifts_mealsnumber'=>1,
            ],
            [
                'bsl_cmn_shifts_name'=>'Truck Shift',
                'bsl_cmn_shifts_starttime'=>'07:00:00',
                'bsl_cmn_shifts_endtime'=>'06:59:59',
                'bsl_cmn_shifts_mealsnumber'=>2,
            ],
            [
                'bsl_cmn_shifts_name'=>'Fumba Shift',
                'bsl_cmn_shifts_starttime'=>'08:00:00',
                'bsl_cmn_shifts_endtime'=>'23:59:59',
                'bsl_cmn_shifts_mealsnumber'=>1,
            ],
        ]);
    }
}
