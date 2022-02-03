<?php namespace Dplus\Reports\Json\Requests;

/**
 * Fetcher
 * 
 * Fetches Json Files
 * @param string $dir      Directory Path
 * @param string $errorMsg Last Error Message
 * 
 * NOTE: set Cgibin::setCgi() Before Using
 * 
 */
class Cgibin {
	static private   $instance;
	static protected $cgi;
	public $errorMsg;
	protected $sessionID;

	private function __construct($sessionID = '') {
		$this->sessionID = $sessionID ? $sessionID : session_id();
	}

	/**
	 * Return Instance
	 * @return self
	 */
	public static function instance($sessionID = '') {
		if (empty(self::$instance)) {
			self::$instance = new self($sessionID);
		}
		return self::$instance;
	}

	/**
	 * Set CGI Script Name
	 * @param  string $cgi Script Name
	 * @return void
	 */
	public static function setCgi($cgi) {
		self::$cgi = $cgi;
	}

	/**
	 * Send Request for Report
	 *
	 * @param  string $report
	 * @param  string $id
	 * @return void
	 */
	public function request($report, $id) {
		$writer = Writer::instance();
		$writer->write($report, $id, $this->sessionID);

		$cgi = self::$cgi;
		$requestUri = "127.0.0.1/cgi-bin/$cgi?fname=$this->sessionID";
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $requestUri
		]);
		$result = curl_exec($ch);
	}
}