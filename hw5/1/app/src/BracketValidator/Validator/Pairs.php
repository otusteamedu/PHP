<?php
declare(strict_types=1);

namespace BracketValidator\Validator;

use BracketValidator\BracketValidator;
use BracketValidator\BracketValidatorException;

class Pairs implements ValidatorInterface
{
    /**
     * @throws BracketValidatorException
     */
    public function validate(string $str): void
    {
        $rightBracket = self::getRightBracket();
        $leftBracket = self::getLeftBracket();
        $characters = self::split($str);
        $unpaired = 0;

        foreach ($characters as $character) {
            if ($character == $leftBracket) {
                $unpaired++;
            }
            if ($character == $rightBracket) {
                $unpaired--;
            }

            if ($unpaired < 0) {
                break;
            }
        }

        if ($unpaired !== 0) {
            throw new BracketValidatorException(
                'В строке есть не парные скобки'
            );
        }
    }

    private static function getRightBracket(): string
    {
        $brackets = self::getBrackets();
        return array_pop($brackets);
    }

    private static function getLeftBracket(): string
    {
        $brackets = self::getBrackets();
        return array_shift($brackets);
    }

    private static function getBrackets(): array
    {
        return self::split(BracketValidator::ALLOWED_SYMBOLS);
    }

    private static function split(string $string): array
    {
        if (empty($string)) {
            return [];
        }

        return str_split($string);
    }
}