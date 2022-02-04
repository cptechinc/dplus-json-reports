<?php namespace Dplus\Reports\Json\Report;

/**
 * Json
 * Container for the JSON report
 * 
 * @property string $report Report Code
 * @property string $id     Report ID
 * @property array  $json   Full JSON data
 * @property array  $fields Column Data
 * @property array  $data   The Report Data
 */
class Json {
	protected $report = '';
	protected $id     = '';
	protected $json   = [];
	protected $fields = [];
	protected $data   = [];

	/** @var array Justify codes for each fieldtype code */
	const FIELDTYPE_JUSTIFY = [
		'C' => 'left',
		'D' => 'left',
		'I' => 'right',
		'N' => 'right'
	];

	public function __construct($report, $id) {
		$this->report = $report;
		$this->id = $id;
	}

	/**
	 * Return Fields Data
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Return Report Data
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Set JSON
	 * @param array $json
	 * @return void
	 */
	public function setJson($json = []) {
		$this->json = $json;
		$this->parseJson();
	}

	/**
	 * Return Field Justify Code for field
	 * @param  string $key Fieldname / Key
	 * @return string
	 */
	public function getFieldJustify($key) {
		$field = $this->fields[$key];
		return self::FIELDTYPE_JUSTIFY[$field['type']];
	}

	/**
	 * Parse JSON data into properties
	 * @return void
	 */
	protected function parseJson() {
		$this->id = $this->json['reportid'];

		if (array_key_exists('columnlabels', $this->json)) {
			$this->fields = $this->json['columnlabels'];
		}

		if (array_key_exists('data', $this->json)) {
			$this->data = $this->json['data'];
		}
	}
}