<?php

// The following code can be used to submit an issue with the PHPSpreadsheet calculation engine

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedFormula;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('UTC');

// Adjust the path as required to reference the PHPSpreadsheet Bootstrap file
require_once __DIR__ . '/Bootstrap.php';

$spreadsheet = new Spreadsheet;

$worksheet = $spreadsheet->getActiveSheet();

$spreadsheet->setActiveSheetIndex(0);
$worksheet = $spreadsheet->getActiveSheet();

// Set up some basic data
$worksheet
    ->setCellValue('A1', 'Tax Rate:')
    ->setCellValue('B1', '=19%')
    ->setCellValue('A3', 'Net Price:')
    ->setCellValue('B3', 12.99)
    ->setCellValue('A4', 'Tax:')
    ->setCellValue('A5', 'Price including Tax:');

// Define named ranges
$spreadsheet->addNamedRange( new \PhpOffice\PhpSpreadsheet\NamedRange('TAX_RATE', $worksheet, '=$B$1'));
$spreadsheet->addNamedRange( new \PhpOffice\PhpSpreadsheet\NamedRange('PRICE', $worksheet, '=$B$3'));

// Reference that defined name in a formula
$worksheet
    ->setCellValue('B4', '=PRICE*TAX_RATE')
    ->setCellValue('B5', '=PRICE*(1+TAX_RATE)');

echo sprintf(
    'With a Tax Rate of %.2f and a net price of %.2f, Tax is %.2f and the gross price is %.2f',
    $worksheet->getCell('B1')->getCalculatedValue(),
    $worksheet->getCell('B3')->getValue(),
    $worksheet->getCell('B4')->getCalculatedValue(),
    $worksheet->getCell('B5')->getCalculatedValue()
), PHP_EOL;
