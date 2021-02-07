<?php

namespace Thomzee\Avana\Controllers;

use Thomzee\Avana\Libraries\Excel\ExcelLibrary;

class MainController
{
    public function index()
    {
        echo "Available excel files: \n";
        $scan = scandir('excels');
        foreach($scan as $file) {
            if (!is_dir("excels/$file")) {
                echo "* $file\n";
            }
        }
        echo "Type filename to select: ";
        $filename = fopen("php://stdin","r");
        $filename = trim(fgets($filename));

        if (file_exists("excels/$filename")) {
            echo "$filename is selected\n";
            $excel = new ExcelLibrary($filename);
            $excel->read();
        } else {
            echo "The file $filename does not exist\n";
        }
    }
}