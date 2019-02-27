<?php
namespace src;

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MyReader implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{

	private $inputFileExtension;
	private $inputFileName;
	private $arrayClean = [];
	private $columnName;
	private $numberSheets;
	private $highestRow;
	private $worksheetName;	
	private $reader;
	private $spreadsheet;	

	public function __construct($inputFileExtension, $inputFileName) {
        $this->inputFileExtension = $inputFileExtension;
        $this->inputFileName = $inputFileName;
        $this->reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileExtension);
		$this->reader->setReadDataOnly(true);
		$this->spreadsheet = $this->reader->load($this->inputFileName);
    }

    public function readCell($column, $row, $worksheetName = ''){
		if ($row >= $this->startRow && $row <= $this->endRow) {
            if (in_array($column,$this->columns)) {
                return true;
            }
        }
        return false;
    }

    public function readAllCellsOfRow() {
    	$dataArray = $this->spreadsheet->getActiveSheet()
		    ->rangeToArray(
		        'C2:C3',     // The worksheet range that we want to retrieve
		        NULL,        // Value that should be returned for empty cells
		        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
		        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
		        TRUE         // Should the array be indexed by cell row and cell column
		    );


		foreach ($dataArray as $key => $value) {				
		    $arrayClean[] = $value['C'];		
		}

		/* This part is to create a txt ile whith the result
		$myfile = fopen("urls.txt", "w") or die("Unable to open file!");

		foreach (array_unique($arrayClean) as $key => $value) {
		    $txt = $value."\n";
		    fwrite($myfile, $txt);
		}

		fclose($myfile);*/
		return $arrayClean;
    }    

    public function getNumbersSheets() {
    	return $this->reader->load($this->inputFileName)->getSheetCount();
    }
    public function getNamesSheets() {
    	return $this->reader->load($this->inputFileName)->getSheetNames();	
    }
    public function getNumberOfRows() {
    	return $this->spreadsheet->getActiveSheet()->getHighestRow();
    }
}