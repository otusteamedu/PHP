<?php

namespace Otus;

class App
{
	public string $string;
	public string $message = 'Error';

	public function __construct($string)
	{
		$this->string = $string;

		if (!$this->verifyString()) {
			http_response_code(400);
		}

		echo $this->message;
	}

	public function verifyString(): bool
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

		$this->message = 'The check was successful! String - ' . $this->string;

		return true;
	}

	public function checkEmpty(): bool
	{
		if (is_string($this->string) && strlen($this->string) > 0) {
			return true;
		}

		return false;
	}

	public function checkCountOfSymbols(): bool
	{
		if (strlen($this->string) <= 54 && strlen($this->string) > 0) {
			return true;
		}

		return false;
	}

	public function customCheck(): bool
	{
		if (strlen($this->string) % 2 !== 0) {
			return false;
		}

		$stack = [];
		for ($i = 0; $i < strlen($this->string); $i++) {
			switch ($this->string[$i]) {
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
