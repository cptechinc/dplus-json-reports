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

	public function __construct($report, $id) {
		$this->report = $report;
		$this->id = $id;
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
	 * Parse JSON data into properties
	 * @return void
	 */
	protected function parseJson() {
		$this->codeid = $this->json['report'] . '-' . $this->json['reportID'];

		if (array_key_exists('fields', $this->json)) {
			$this->data = $this->json['fields'];
		}

		if (array_key_exists('data', $this->json)) {
			$this->data = $this->json['data'];
		}
	}
}