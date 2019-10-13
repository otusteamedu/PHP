<?php
namespace MyValidator;

class Validator
{
	private $string;

	public function __construct($string) {
		$this->string = htmlentities($string);
	}

	public function validate () {
		$len = strlen($this->string);
		$stack = [];
		for ($i = 0; $i < $len; $i++) {
			switch ($this->string[$i]) {
				case '(': array_push($stack, 0); break;
				case ')':
					if (array_pop($stack) !== 0)
						return false;
					break;
				case '[': array_push($stack, 1); break;
				case ']':
					if (array_pop($stack) !== 1)
						return false;
					break;
				default: break;
			}
		}
		return (empty($stack));
	}
}