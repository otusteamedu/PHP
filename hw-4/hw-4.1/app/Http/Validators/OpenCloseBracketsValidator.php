<?php

namespace App\Http\Validators;


use App\Http\Validators\Contracts\ValidatorInterface;

class OpenCloseBracketsValidator extends BaseValidator
{

    private $length;

    public function __construct($field)
    {
        parent::__construct($field);
    }

    public function validate()
    {
        $stack = [];
        for ($i = 0; $i < strlen($this->field); $i++) {
            $bracket = $this->field[$i];
            if ($bracket === '(') {
                array_push($stack, $bracket);
                continue;
            }

            if ($stack[array_key_last($stack)] !== '(') {
                return false;
            }
            array_pop($stack);
        }
        if (count($stack) > 0) {
            return false;
        }
        return true;
    }
}
