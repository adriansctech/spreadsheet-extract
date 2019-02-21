<?php

	require 'vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	$sheetname = '1 - Client Error (4xx) Inlinks';
	$inputFileType = 'Xls';
	$inputFileName = './hreflangs-to-change.xls';
	$arrayClean = [];
	$columnName = 'C';

	/**  Define a Read Filter class implementing \PhpOffice\PhpSpreadsheet\Reader\IReadFilter  */
	class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
	{
	    private $startRow = 0;
	    private $endRow   = 0;
	    private $columns  = [];

	    /**  Get the list of rows and columns to read  */
	    public function __construct($startRow, $endRow, $columns) {
	        $this->startRow = $startRow;
	        $this->endRow   = $endRow;
	        $this->columns  = $columns;
	    }

	    public function readCell($column, $row, $worksheetName = '') {	        
	        if ($row >= $this->startRow && $row <= $this->endRow) {
	            if (in_array($column,$this->columns)) {
	                return true;
	            }
	        }
	        return false;
	    }

	    public function getStartRow(){
	    	return $this->startRow;
	    }

	    public function getEndRow(){
	    	return $this->endRow;
	    }
	    public function getColumns(){
	    	return $this->columns;
	    }
	}

	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true);	
	$spreadsheet = $reader->load($inputFileName);
	//Get number of rows 
	$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

	$dataArray = $spreadsheet->getActiveSheet()
	    ->rangeToArray(
	        'C2:C'.$highestRow,     // The worksheet range that we want to retrieve
	        NULL,        // Value that should be returned for empty cells
	        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
	        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
	        TRUE         // Should the array be indexed by cell row and cell column
	    );

	
	foreach ($dataArray as $key => $value) {				
		$arrayClean[] = $value[$columnName];		
	}	
	$myfile = fopen("urls.txt", "w") or die("Unable to open file!");;
	foreach (array_unique($arrayClean) as $key => $value) {
		$txt = $value."\n";
		fwrite($myfile, $txt);
	}
	fclose($myfile);
    die("");
