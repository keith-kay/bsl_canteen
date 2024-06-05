<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        ##
        DB::table('bsl_cmn_users')->insert([
            [
                'bsl_cmn_users_firstname' => 'John',
                'bsl_cmn_users_lastname' => 'Doe',
                'bsl_cmn_users_employment_number' => 'G1234567',
                'bsl_cmn_users_pin' => '1234',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
            [
                'bsl_cmn_users_firstname' => 'Steven',
                'bsl_cmn_users_lastname' => 'Haule',
                'bsl_cmn_users_employment_number' => 'FP-035',
                'bsl_cmn_users_pin' => '2345',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
            [
                'bsl_cmn_users_firstname' => 'Henrick',
                'bsl_cmn_users_lastname' => 'Dastan',
                'bsl_cmn_users_employment_number' => 'FP-042',
                'bsl_cmn_users_pin' => '3456',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
            [
                'bsl_cmn_users_firstname' => 'Keith',
                'bsl_cmn_users_lastname' => 'Rhova',
                'bsl_cmn_users_employment_number' => 'FP-042',
                'bsl_cmn_users_pin' => '4567',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
        ]);

        DB::table('bsl_cmn_user_types')->insert([
            ['bsl_cmn_user_types_name'=>'Staff'],
            ['bsl_cmn_user_types_name'=>'Contractor'],
            ['bsl_cmn_user_types_name'=>'Visitor'],
            ['bsl_cmn_user_types_name'=>'Logistics'],
            ['bsl_cmn_user_types_name'=>'BSL'],
        ]);
        DB::table("roles")->insert([
            [
                'name' => 'super-admin',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'user',
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
            ],
        ]);

    }
}
