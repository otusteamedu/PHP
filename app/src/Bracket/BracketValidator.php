<?php

namespace App\Bracket;

use App\Exceptions\RequestException;
use App\Response;

class BracketValidator
{
    private string $brackets;

    public function __construct(string $brackets)
    {
        $this->brackets = $brackets;
    }

    public function check()
    {
        if (!$this->validate()) {
            throw new RequestException('invalid format', 400);
        }

        Response::send(200, 'correct');
    }

    private function validate() : bool
    {

        if (empty(trim($this->brackets))) {
            return false;
        }

        if ( ($this->brackets[0] === ')') || (substr($this->brackets, -1, 1) === '(') ) {
            return false;
        }

        foreach (str_split($this->brackets) as $value) {

            if ($value === '(') {
                $arr[] = $value;
                continue;
            }

            if ($value === ')' && (empty($arr) || array_pop($arr) !== '(')) {
                return false;
            }
        }

        return empty($arr);
    }
}
