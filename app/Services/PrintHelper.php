<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use App\Models\CustomUser;

class PrintHelper
{

    public string $printerAddress;
    public int $printerPort;
    function __construct($printerAddress, $printerPort = 9100)
    {
        $this->printerAddress = $printerAddress;
        $this->printerPort = $printerPort;
    }
    public function print($message)
    {
        echo $message;
    }

    public function isOnline(): bool {
        // Create a socket connection to the printer
        $connection = @fsockopen($this->printerAddress, $this->printerPort, $errno, $errstr, 5);
        if ($connection) {
            fclose($connection); // Close the connection if successful
            return true; // Printer is online
        } else {
            return false; // Printer is offline
        }
    }

    public function printMealTicket($mealDetails)
    {
        try {
            $connector = new NetworkPrintConnector($this->printerAddress, $this->printerPort);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->setEmphasis(true);

            // $resizedLogoPath = $this->resizeImage(public_path('images/logo.png'), 300, 100); // Adjust dimensions as needed
            // $logo = EscposImage::load($resizedLogoPath, false);

            // $printer->bitImage($logo);
            $printer->text("MEAL TICKET\n");
            $printer->text("Meal type: " . $mealDetails->mealtype . "\n\n");
            $printer->setEmphasis(false);
            $printer->selectPrintMode();
            $printer->feed(1);
            # //Barcode
            /* 
            $barcodedata = "{B".$object->userdetails;
            $printer -> setJustification(Printer::JUSTIFY_CENTER);
            $printer -> setBarcodeHeight(50);
            $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
            $printer -> barcode($barcodedata, Printer::BARCODE_CODE128);
            $printer -> feed(2);
    */
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            
            $printer->text("Staff ID: " . $mealDetails->staffid . "\n");
            $printer->text("Name: " . $mealDetails->userName . "\n");
            $printer->text("Company: " . $mealDetails->company . "\n");
            $printer->text("Department: " . $mealDetails->department . "\n");
            // $printer->text("Meal type: " . $mealDetails->mealtype . "\n");
            $printer->text("Time: " . $mealDetails->date . "\n");
            $printer->text("Site: " . $mealDetails->site . "\n");
            $printer->feed(3);

            //Receipt owner
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            //$printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->setEmphasis(true);
            $printer->text("Please present to get meal\n");
            $printer->setEmphasis(false);
            $printer->selectPrintMode();
            $printer->feed(4);

            # Cut the receipt
            $printer->cut();
            # Close the printer connection
            $printer->close();
        } catch (\Exception $e) {
            throw new \Exception("Error printing meal ticket: " . $e->getMessage());
        }
    }

    // public function printMealTicket($mealDetails)
    // {
    //     $connector = new NetworkPrintConnector($this->printerAddress, $this->printerPort);
    //     $printer = new Printer($connector);
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer->setEmphasis(true);

    //     // $resizedLogoPath = $this->resizeImage(public_path('images/logo.png'), 300, 100); // Adjust dimensions as needed
    //     // $logo = EscposImage::load($resizedLogoPath, false);

    //     //$printer->bitImage($logo);
    //     $printer->text("MEAL TICKET\n");
    //     $printer->text("Meal type: " . $mealDetails->mealtype . "\n\n");
    //     $printer->setEmphasis(false);
    //     $printer->selectPrintMode();
    //     $printer->feed(1);
        
    //     // Retrieve user by staff ID
    //     $user = CustomUser::where('bsl_cmn_users_employment_number', $mealDetails->staffid)->first();
        
    //     // Get the created_at date for the date range
    //     $fromDate = $user ? $user->created_at->format('Y-m-d') : now()->format('Y-m-d');
        
    //     // Assuming you have a days field in the user model that indicates the number of days
    //     $daysAssigned = $user ? $user->bsl_cmn_users_days : 0; // Adjust if you have a different field
    //     $toDate = now()->addDays($daysAssigned)->format('Y-m-d');

    //     // Print user details
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->text("Staff ID: " . $mealDetails->staffid . "\n");
    //     $printer->text("Name: " . $mealDetails->userName . "\n");
    //     $printer->text("Company: " . $mealDetails->company . "\n");
    //     $printer->text("Department: " . $mealDetails->department . "\n");
    //     $printer->text("Time: " . $mealDetails->date . "\n");
    //     $printer->text("Site: " . $mealDetails->site . "\n");
    //     $printer->feed(3);

    //     // Print the italicized date range line for guests
    //     if ($user && $user->bsl_cmn_users_type == 9) { // Check if user is a guest
    //         $printer->setEmphasis(true);
    //         $printer->setJustification(Printer::JUSTIFY_CENTER);
    //         $printer->setFont(Printer::FONT_B); // Italic font (if supported by the printer)
    //         $printer->text("From: $fromDate to: $toDate\n");
    //         $printer->setFont(Printer::FONT_A); // Switch back to normal font
    //         $printer->setEmphasis(false);
    //     }

    //     // Receipt owner
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->setEmphasis(true);
    //     $printer->text("Please present to get meal\n");
    //     $printer->setEmphasis(false);
    //     $printer->feed(4);

    //     // Cut the receipt
    //     $printer->cut();
    //     // Close the printer connection
    //     $printer->close();
    // }


    // private function resizeImage($file, $width, $height)
    // {
    //     list($originalWidth, $originalHeight) = getimagesize($file);
    //     $source = imagecreatefrompng($file); // Adjust based on image type, e.g., imagecreatefromjpeg

    //     $resizedImage = imagecreatetruecolor($width, $height);

    //     imagealphablending($resizedImage, false);
    //     imagesavealpha($resizedImage, true);

    //     imagecopyresampled(
    //         $resizedImage,
    //         $source,
    //         0,
    //         0,
    //         0,
    //         0,
    //         $width,
    //         $height,
    //         $originalWidth,
    //         $originalHeight
    //     );

    //     $resizedFilePath = sys_get_temp_dir() . '/resized_logo.png';
    //     imagepng($resizedImage, $resizedFilePath);

    //     imagedestroy($source);
    //     imagedestroy($resizedImage);

    //     return $resizedFilePath;
    // }

    private function logToDB($mealDetails)
    {
        // Log the meal ticket to the database
    }
}
