<?php
require_once "src/MyReader.php";

use src\MyReader as Reader;

$excelReader = new Reader($inputFileExtension= 'Xlsx', $inputFileName = './files/Financial Sample.xlsx');

echo "Number of sheets: " . $excelReader->getNumbersSheets() . "\n";
echo "Active sheet name: " . $excelReader->getNamesSheets()[0] . "\n";
//var_dump($excelReader->getNamesSheets()) . "\n";
echo "Number of records: " . $excelReader->getNumberOfRows() . "\n";
var_dump($excelReader->readAllCellsOfRow());