<?php

namespace Thomzee\Avana\Libraries\Excel;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelLibrary
{
    const FILE_DIR = 'excels/';
    protected $filename;
    protected $fullPath;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->fullPath = self::FILE_DIR.$filename;
    }

    /**
     * @throws Exception
     */
    public function read()
    {
        try {
            $inputFileType = IOFactory::identify($this->fullPath);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($this->fullPath);
            $data = $spreadsheet->getActiveSheet()->toArray();

            if (empty($data[0])) {
                throw new Exception('Headings not found.');
            }

            $errors = [];
            for($row = 0; $row < sizeof($data); $row++) {
                for($col = 0; $col < sizeof($data[$row]); $col++) {
                    if ($row != 0) {
                        // process value
                        if ($this->startsWith($data[0][$col], '#')) {
                            // must not contain spaces
                            if (preg_match('/\s/', $data[$row][$col])) {
                                $errors[$row][] = $data[0][$col] . " should not contain any space";
                            }
                        }

                        if ($this->endsWith($data[0][$col], '*')) {
                            // must not empty
                            if (empty($data[$row][$col])) {
                                $errors[$row][] = "Missing value in " . $data[0][$col];
                            }
                        }
                    }
                }
            }

            if (!empty($errors)) {
                $this->output($errors);
            } else {
                echo "All is good.\n";
            }

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading file: '.$e->getMessage());
        }
    }

    private function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    private function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    private function output($errors)
    {
        echo '============'.PHP_EOL;
        echo str_pad('Row', 5) . '| Error' . PHP_EOL;
        echo '============'.PHP_EOL;
        foreach ($errors as $row => $error) {
            echo str_pad($row, 5) . '| ' . implode(', ', $error) . PHP_EOL;
        }
    }
}