<?php namespace Dplus\Reports\Json\Report;

/**
 * Emails
 * Container for Emails
 * 
 * @property array[Emails\Email] $to    Emails to Email to
 * @property Emails\Email        $from  Emails to Email from
 */
class Emails {
	protected $to    = [];
	protected $from  = null;


	public function setFromEmailFromArray(array $data) {
		$email = new Emails\Email();
		$email->setFromArray($data);
		$this->from = $email;
	}

	public function setToEmailsFromArray(array $data) {
		$emails = [];

		foreach ($data as $key => $em) {
			$email = new Emails\Email();
			$email->setFromArray($em);
			$emails[$key] = $email;
		}
		$this->to = $emails;
	}
}