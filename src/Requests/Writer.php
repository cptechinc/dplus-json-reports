<?php namespace Dplus\Reports\Json\Requests;

/**
 * Requests\Writer
 * 
 * Writes Request Files
 * 
 * NOTE: set Writer::setDir(), Writer::setDbname() Before Using
 */
class Writer {
	static private   $instance;
	static protected $dir;
	static protected $dbname;

	private function __construct() {
		
	}

	/**
	 * Set Directory to Write to
	 * @param  string $dir Directory Path
	 * @return void
	 */
	public static function setDir($dir) {
		self::$dir = rtrim($dir, '/') . '/';
	}

	/**
	 * Set Database Name
	 * @param  string $dbname
	 * @return void
	 */
	public static function setDbname($dbname) {
		self::$dbname = $dbname;
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
	 * Return Data for Request File
	 * @param  string $report
	 * @param  string $id
	 * @return array
	 */
	public function createData($report, $id) {
		return [
			"DBNAME=" . self::$dbname,
			"REPORT=$report",
			"ID=$id"
		];
	}

	/**
	 * Write File
	 * @param  string $report
	 * @param  string $id
	 * @return bool
	 */
	public function write($report, $id, $filename) {
		$content = implode("\n", $this->createData($report, $id));
		$file    = self::$dir . $filename;
		return boolval(file_put_contents($file, $content));
	}
}