<?php

namespace App\Http;

class ParenthesesValidator
{
    public function validate(string $string): bool
    {
        $string = $this->prepareString($string);
        return $this->isStringCorrect($string);
    }

    protected function prepareString(string $string): string
    {
        return str_replace(' ', '', $string);
    }

    protected function isStringCorrect(string $string): bool
    {
        while ($string !== '') {
            if (strpos($string, '()') === false) {
                break;
            }

            $string = str_replace('()', '', $string);
        }

        return $string === '';
    }
}