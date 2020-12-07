<?php


class App
{
	public $data;
	public string $message = 'Error';

	public function __construct($data)
	{
		$this->data = $data;

		if (!$this->verifyString()) {
			http_response_code(400);
		}

		echo $this->message;
	}

	public function verifyString()
	{
		if (!$this->checkEmpty()) {
			$this->message = 'This string is empty!';
			return false;
		}

		if (!$this->checkCountOfSymbols()) {
			$this->message = 'String length must be between 1 AND 54';
			return false;
		}

		if (!$this->customCheck()) {
			$this->message = 'Wrong brackets position';
			return false;
		}

		$this->message = 'The check was successful! String - ' . $this->data;

		return true;
	}

	public function checkEmpty()
	{
		if (!empty($this->data)) {
			return true;
		}

		return false;
	}

	public function checkCountOfSymbols()
	{
		if (isset($this->data['string']) && strlen($this->data['string']) <= 54 && strlen($this->data['string']) > 0) {
			return true;
		}

		return false;
	}

	public function customCheck()
	{
		if (strlen($this->data['string']) % 2 !== 0) {
			return false;
		}

		$stack = [];
		for ($i = 0; $i < strlen($this->data['string']); $i++) {
			switch ($this->data['string'][$i]) {
				case '(':
					array_push($stack, 0);
					break;
				case ')':
					if (array_pop($stack) !== 0) $stack = [];
					break;
				default:
					$stack = [];
					break(2);
			}
		}
		return (empty($stack));
	}
}
