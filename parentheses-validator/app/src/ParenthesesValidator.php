<?php

namespace App;

use InvalidArgumentException;
use function str_split;

/**
 * Class ParenthesesValidator
 *
 * @package App
 */
class ParenthesesValidator
{
    /**
     * @param  string|null  $string
     *
     * @return bool
     */
    public function validate(?string $string): bool
    {
        $counter = 0;

        $array = str_split($string);

        foreach ($array as $item) {
            switch ($item) {
                case '(':
                    $counter++;
                    break;
                case ')':
                    $counter--;
                    break;
                default:
                    throw new InvalidArgumentException('Обнаружен неверный символ: "' . $item . '"');
            }

            if ($counter < 0) {
                return false;
            }
        }

        return $counter === 0;
    }
}