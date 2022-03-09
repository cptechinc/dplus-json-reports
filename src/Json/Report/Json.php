<?php namespace Dplus\Reports\Json\Report;

/**
 * Json
 * Container for the JSON report
 * 
 * @property string $report 	 Report Code
 * @property string $id 		 Report ID
 * @property array	$json		 Full JSON data
 * @property array	$fields 	 Column Data
 * @property array	$data		 The Report Data
 * @property bool	$hasHeaders  Does Report Have Headings? (Different from Column Headings)
 * @property Emails $emails      
 */
class Json {
	protected $report = '';
	protected $id	  = '';
	protected $json   = [];
	protected $fields = [];
	protected $data   = [];
	protected $hasHeaders = false;
	protected $emails      = null;

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
		$this->emails = new Emails();
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
	 * Return Emails
	 * @return array
	 */
	public function getEmails() {
		return $this->emails;
	}

	/**
	 * Return if Report Has Headers
	 * @return bool
	 */
	public function hasHeaders() {
		return $this->hasHeaders;
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

		$this->parseJsonEmails();
		$this->hasHeaders = $this->parseJsonForHeaders();
	}

	protected function parseJsonEmails() {
		if (array_key_exists('email', $this->json)) {
			$this->emails->setToEmailsFromArray($this->json['email']);
		}
	}

	/**
	 * Determines if JSON has heading indexes for Report
	 * @return bool
	 */
	protected function parseJsonForHeaders() {
		foreach ($this->data as $record) {
			if (array_key_exists('header', $record) && $record['header']) {
				return true;
			}
		}
		return false;
	}
}