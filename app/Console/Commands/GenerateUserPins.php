<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomUser;  
use Illuminate\Support\Facades\Mail;  
use App\Mail\PinMail; 

class GenerateUserPins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-pins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Pins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch users who do not have a PIN
        $usersWithoutPins = CustomUser::whereNull('bsl_cmn_users_pin')
            ->whereNotNull('email') // Ensure email exists for sending
            ->get();

        // Check if there are users without PINs
        if ($usersWithoutPins->isEmpty()) {
            $this->info('No users found without PINs.');
            return;
        }

        foreach ($usersWithoutPins as $user) {
            // Generate a random 4-digit PIN
            $pin = mt_rand(1000, 9999);

            // Update the user with the new PIN
            $user->bsl_cmn_users_pin = $pin;
	    try{
	    	$user->save();
	    } catch(\Exception $e){
		    $this->info('PIN generation failed for user: ['.$user->email.'] Due to: '.$e->getMessage());
		    report($e);
		    continue;
	    }
            // Send the PIN via email
            Mail::to($user->email)->send(new PinMail($pin));

            // Output info for each user processed
            $this->info('PIN generated and emailed for user: ' . $user->email);
        }

        $this->info('All eligible users have been processed.');
    }
}
