<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

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

    public function printMealTicket($mealDetails)
    {
        $connector = new NetworkPrintConnector($this->printerAddress, $this->printerPort);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->setEmphasis(true);

        $resizedLogoPath = $this->resizeImage(public_path('images/logo.png'), 300, 100); // Adjust dimensions as needed
        $logo = EscposImage::load($resizedLogoPath, false);

        $printer->bitImage($logo);
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
    }

    private function resizeImage($file, $width, $height)
    {
        list($originalWidth, $originalHeight) = getimagesize($file);
        $source = imagecreatefrompng($file); // Adjust based on image type, e.g., imagecreatefromjpeg

        $resizedImage = imagecreatetruecolor($width, $height);

        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);

        imagecopyresampled(
            $resizedImage,
            $source,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $originalWidth,
            $originalHeight
        );

        $resizedFilePath = sys_get_temp_dir() . '/resized_logo.png';
        imagepng($resizedImage, $resizedFilePath);

        imagedestroy($source);
        imagedestroy($resizedImage);

        return $resizedFilePath;
    }

    private function logToDB($mealDetails)
    {
        // Log the meal ticket to the database
    }
}
