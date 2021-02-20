<?php

namespace App\Validators;


class BracketValidator implements Validator
{

    private $isValid = false;
    private $value = null;

    public function validate(): BracketValidator
    {
        $value = preg_replace('/[^(^).*]/', '', $this->value);
        $open = $close = 0;
        foreach (str_split($value) as $char) {
            switch ($char) {
                case '(':
                    ++$open;
                    break;
                case ')':
                    ++$close;
                    if ($close > $open) {
                        break 2;
                    }
                    break;
            }
        }
        $this->isValid = $open === $close;
        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function setValue($value): BracketValidator
    {
        $this->value = $value;
        return  $this;
    }
}