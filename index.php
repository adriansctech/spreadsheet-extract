<?php
require_once "src/MyReader.php";

use src\MyReader as Reader;

$excelReader = new Reader($inputFileExtension= 'Xlsx', $inputFileName = './files/Financial Sample.xlsx');

//echo $excelReader->getNumbersSheets();
//var_dump($excelReader->getNamesSheets());
//echo $excelReader->getNumberOfRows();
//var_dump($excelReader->readAllCellsOfRow());