<?php namespace Dplus\Reports\Json\Spreadsheets\Writer;
// PhpSpreadsheet Library
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// Dplus Spreadsheets
use Dplus\Reports\Json\Spreadsheets\Writer;

/**
 * Writer\Xlsx
 * Handles Writing Xlsx files
 */
class Xlsx extends Writer {
	const EXTENSION = 'xlsx';

	/**
	 * Return Spreadsheet File Writer
	 * @return BaseWriter
	 */
	protected function getWriter(Spreadsheet $spreadsheet) {
		$writer = new WriterXlsx($spreadsheet);
		return $writer;
	}
}
