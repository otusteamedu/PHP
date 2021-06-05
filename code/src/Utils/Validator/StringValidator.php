<?php


namespace App\Utils\Validator;


class StringValidator
{
    public function validate(?string $value, int $maxLength, int $minLength = 1): bool
    {
        if (! $value) {
            return false;
        }

        $strLength = strlen($value);

        if ($strLength < $minLength || $strLength > $maxLength) {
            return false;
        }

        return true;
    }

}
