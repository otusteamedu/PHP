<?php

namespace App\Bracket;

use App\Exceptions\RequestException;
use App\Response;

class BracketValidator
{
    private array $brackets;

    public function __construct(string $brackets)
    {
        $this->brackets = str_split($brackets);
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
        if (empty($this->brackets)) {
            return false;
        }

        $counter = 0;
        foreach ($this->brackets as $bracket) {
            if ($bracket === '(') {
                $counter++;
            } else {
                $counter--;
            }
        }
        return $counter === 0 && end($this->brackets) !== '(';
    }
}
