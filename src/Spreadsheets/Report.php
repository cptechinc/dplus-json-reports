<?php namespace Dplus\Reports\Json\Spreadsheets;
// PhpSpreadsheet Library
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style as SpreadsheetStyles;

use Dplus\Reports\Json\Report\Json;

/**
 * Spreadsheets\Report
 * Creates and populates Spreadsheet class
 * 
 * @property Spreadsheet $spreadsheet Spreadsheet Data
 * @property Json        $json        JSON Data Container
 */
class Report {
	protected $spreadsheet;
	protected $json;

	/** @var array Column Heading Styles */
	const STYLES_COLUMN_HEADER = [
		'font' => [
			'bold' => true,
			'size' => 14
		],
		'borders' => [
			'bottom' => [
				'borderStyle' => SpreadsheetStyles\Border::BORDER_THICK,
			],
		],
	];

	public function __construct() {
		$this->spreadsheet = new Spreadsheet();
	}

	/**
	 * Set Json
	 * @param Json $json  JSON Container
	 * @return void
	 */
	public function setJson(Json $json) {
		$this->json = $json;
	}

	/**
	 * Populate Spreadsheet
	 * @return void
	 */
	public function generate() {
		$this->generateHeader();
		$this->generateBody();
	}

	/**
	 * Populates Column Headers in the Spreadsheet
	 * @return void
	 */
	private function generateHeader(){
		$sheet = $this->spreadsheet->getActiveSheet();
		$colCount = count($this->json->fields);
		Writer::setColumnsAutowidth($sheet, $colCount);

		$row = 1;
		$i = 1;
		foreach ($this->json->fields as $key => $field) {
			$cell = $sheet->getCellByColumnAndRow($i, $row);
			$cell->getStyle()->applyFromArray(static::STYLES_COLUMN_HEADER);
			$cell->getStyle()->getAlignment()->setHorizontal(Writer::getAlignmentCode($field['justify']));
			$cell->setValue($field['label']);
			$i++;
		}
	}

	private function generateBody() {

	}
}
