<?php

declare(strict_types=1);

namespace App\Validators;

class RoundBracketsValidator implements StringValidatorInterface
{
    public function validate(string $string): bool
    {
        $openBracket = 0;
        for ($i = 0, $count = strlen($string); $i < $count; ++$i) {
            if ($string[$i] === '(') {
                ++$openBracket;
            } elseif ($string[$i] === ')') {
                if ($openBracket <= 0) {
                    return false;
                }
                --$openBracket;
            }
        }
        return $openBracket === 0;
    }
}
