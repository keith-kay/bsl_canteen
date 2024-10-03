<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
#use Illuminate\Support\Facades\Hash;

class MealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bsl_cmn_mealtypes')->insert([
            [
                'bsl_cmn_mealtypes_mealname'=>'Tea',
                //'bsl_cmn_mealtypes_site'=>1,
                'bsl_cmn_mealtypes_numberofmeals'=>1,
                'bsl_cmn_mealtypes_starthour'=>7,
                'bsl_cmn_mealtypes_duration'=>24,
                'bsl_cmn_mealtypes_status'=>1,
                'created_at'=>Carbon::now(),
            ],
            [
                'bsl_cmn_mealtypes_mealname'=>'Lunch',
                //'bsl_cmn_mealtypes_site'=>1,
                'bsl_cmn_mealtypes_numberofmeals'=>1,
                'bsl_cmn_mealtypes_starthour'=>7,
                'bsl_cmn_mealtypes_duration'=>24,
                'bsl_cmn_mealtypes_status'=>1,
                'created_at'=>Carbon::now(),
            ],
        ]);

    }
}
?>