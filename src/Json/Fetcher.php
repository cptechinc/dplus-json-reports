<?php namespace Dplus\Reports\Json;

/**
 * Fetcher
 * 
 * Fetches Json Files
 * @param string $dir      Directory Path
 * @param string $errorMsg Last Error Message
 */
class Fetcher {
	static private   $instance;
	static protected $dir;
	public $errorMsg;

	private function __construct() {
		
	}

	/**
	 * Return Instance
	 * @return self
	 */
	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set Directory to Fetch From
	 * @param  string $dir Directory Path
	 * @return void
	 */
	public static function setDir($dir) {
		self::$dir = rtrim($dir, '/') . '/';
	}

	/**
	 * Return full file path
	 * @param  string $filename
	 * @return string
	 */
	protected function generateFilePath($filename) {
		return self::$dir.$filename.'.json';
	}

	/**
	 * Check if File Exists
	 * @param  string $filename
	 * @return bool
	 */
	public function exists($filename) {
		return file_exists($this->generateFilePath($filename));
	}
	
	/**
	 * Return Decoded JSON File
	 * @param  string $filename
	 * @return array
	 */
	public function fetch($filename) {
		if ($this->exists($filename) === false) {
			$this->errorMsg = 'File ' . $this->generateFilePath($filename) . ' not found';
		}
		$json = json_decode(file_get_contents($this->generateFilePath($filename)), true);

		if (empty($json)) {
			$this->errorMsg = "The $filename JSON contains errors, JSON ERROR: ". json_last_error();
		}
		return $json;
	}

	/**
	 * Delete File
	 * @param  string $filename
	 * @return bool
	 */
	public function delete($filename) {
		return unlink($this->generateFilePath($filename));
	}

	/**
	 * Return Timestamp of when the file was modified
	 * @param  string $filename
	 * @return int
	 */
	public function modified($filename) {
		$file = $this->generateFilePath($filename);

		if (file_exists($file) === false) {
			return 0;
		}
		return filemtime($file);
	}
}