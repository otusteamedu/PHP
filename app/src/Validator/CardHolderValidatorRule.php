<?php


namespace Otus\Validator;


use Rakit\Validation\Rule;

class CardHolderValidatorRule extends Rule
{
    public function check($value): bool
    {
        $is_string = is_string($value) && preg_match('/^[\pL\pM]+$/u', $value);

        if ($is_string or substr_count($value, ' ') == 1) {
            return true;
        }

        return false;
    }
}
