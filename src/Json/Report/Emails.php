<?php namespace Dplus\Reports\Json\Report;

use Dplus\Reports\Json\Report\Emails\Email;

/**
 * Emails
 * Container for Emails
 * 
 * @property array[Email] $to    Emails to Email to
 * @property Email        $from  Emails to Email from
 */
class Emails {
	protected $to    = [];
	protected $from  = null;

	public function hasTo() {
		return empty($this->to) === false;
	}


	public function setFromEmailFromArray(array $data) {
		$email = new Email();
		$email->setFromArray($data);
		$this->from = $email;
	}

	public function setToEmailsFromArray(array $data) {
		$emails = [];

		foreach ($data as $key => $em) {
			$email = new Email();
			$email->setFromArray($em);
			$emails[$key] = $email;
		}
		$this->to = $emails;
	}
}