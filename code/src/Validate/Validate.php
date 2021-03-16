<?php

namespace Validate;

use Validate\Rule\Rules\BracketAmount;
use Validate\Rule\Rules\FirstLastSymbols;
use Validate\Rule\Rules\Length;

final class Validate {

    protected function valid()
    {
        header("HTTP/1.1 200 OK");
        echo "String is valid";
    }

    protected function notValid()
    {
        header("HTTP/1.1 400 Bad Request");
        echo "String is not valid";
    }

    /**
     * Валидация входящего значения
     *
     * @param $string
     */
    public function validate(string $string): void
    {

        $length = new Length();
        $firstLast = new FirstLastSymbols();
        $bracketAmount = new BracketAmount();


        if ($length->check($string) || $firstLast->check($string) || $bracketAmount->check($string)) {
            $this->notValid();
        } else {
            $this->valid();
        }
    }


}