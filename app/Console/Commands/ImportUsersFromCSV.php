<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class ImportUsersFromCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a CSV file into the bsl_cmn_users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvFile = $this->argument('file');

        // Check if file exists
        if (!file_exists($csvFile) || !is_readable($csvFile)) {
            $this->error("File does not exist or is not readable.");
            return 1;
        }

        // Read the CSV file
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0); // Assuming the first row is the header

        // Loop through each row in the CSV
        foreach ($csv as $row) {
            // Validate each row data
            $validator = Validator::make($row, [
                'name' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'email' => 'required|email|unique:bsl_cmn_users,email',
                'staffno' => 'required|string|max:50|unique:bsl_cmn_users,bsl_cmn_users_employment_number',
            ]);

            if ($validator->fails()) {
                $this->error("Row failed validation: " . implode(", ", $validator->errors()->all()));
                continue; // Skip this row and continue
            }

            // // Extract name fields (assuming "Name" is "Firstname Lastname")
             $nameParts = explode(' ', $row['name']);
             $firstname = $nameParts[0];
             $lastname = isset($nameParts[1]) ? $nameParts[1] : '';

            // Insert user into the bsl_cmn_users table
            DB::table('bsl_cmn_users')->insert([
                'bsl_cmn_users_firstname' => $firstname,
                'bsl_cmn_users_lastname' => $lastname,
                'bsl_cmn_users_department' => $row['department'],
                'email' => $row['email'],
		'bsl_cmn_users_employment_number' => $row['staffno'],
		'bsl_cmn_users_pin' => null,
                'bsl_cmn_users_type' => 1,  
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info("Successfully inserted user: {$firstname} {$lastname}");
        }

        $this->info("CSV import completed.");
        return 0;
    }
}
