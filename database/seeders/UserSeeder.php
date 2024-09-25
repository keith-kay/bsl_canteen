<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'bsl_cmn_users_firstname' => 'Eliya',
                'bsl_cmn_users_lastname' => 'Nakemia',
                'bsl_cmn_users_employment_number' => 'FP-0001',
                'bsl_cmn_users_pin' => '2345',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
            [
                'bsl_cmn_users_firstname' => 'Julie',
                'bsl_cmn_users_lastname' => 'Shali',
                'bsl_cmn_users_employment_number' => 'BSLL-0001',
                'bsl_cmn_users_pin' => '3456',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
            [
                'bsl_cmn_users_firstname' => 'Keith',
                'bsl_cmn_users_lastname' => 'Rhova',
                'bsl_cmn_users_employment_number' => 'MBTL-0001',
                'bsl_cmn_users_pin' => '4567',
                'bsl_cmn_users_type' => 1,
                'password' => Hash::make('P@ssword'),
            ],
        ]);
    }
}
