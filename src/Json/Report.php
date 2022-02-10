<?php namespace Dplus\Reports\Json;

/**
 * Report
 * 
 * @property string      $id        Report ID
 * @property string      $errorMsg  Error Message
 * @property Report\Json $json      Container for JSON data
 */
class Report {
	const CODE = '';
	protected $id = '';
	public $errorMsg = '';
	protected $json;

	/**
	 * Set Report ID
	 * @param  string $id
	 * @return void
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Return Json
	 * @return Report\Json
	 */
	public function getJson() {
		return $this->json;
	}

	/**
	 * Return Report ID
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns Code ID 
	 */
	protected function generateCodeId() {
		return static::CODE . '-' . $this->id;
	}

	/**
	 * Check if Report JSON exists
	 * @return bool
	 */
	public function exists() {
		return Fetcher::instance()->exists($this->generateCodeId());
	}

	/**
	 * Delete Report JSON
	 * @return string
	 */
	public function delete() {
		return Fetcher::instance()->delete($this->generateCodeId());
	}

	/**
	 * Return Report JSON
	 * @return bool
	 */
	public function fetch() {
		if ($this->exists() === false) {
			$this->errorMsg = 'Report ' . $this->generateCodeId() . ' not found';
			return false;
		}
		$json = Fetcher::instance()->fetch($this->generateCodeId());

		if (empty($json)) {
			$this->errorMsg = Fetcher::instance()->errorMsg;
			return false;
		}
		$jsonContainer = new Report\Json(static::CODE, $this->id);
		$jsonContainer->setJson($json);
		$this->json = $jsonContainer;
		return true;
	}

	/**
	 * Request Report 
	 * @return bool
	 */
	public function request() {
		$rqst = Requests\Cgibin::instance();
		$rqst->request(static::CODE, $this->id) ;
	}
}