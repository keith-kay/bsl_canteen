<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ##
        ## CALL SEEDERS
        $this->call([
            UserSeeder::class,
            SiteSeeder::class,
            ShiftSeeder::class,
            MealTypeSeeder::class,
            PrinterSeeder::class,
            UserTypeSeeder::class,
            CustomRolesSeeder::class,
        ]);

    }
}
