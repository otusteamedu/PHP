<?php
declare(strict_types=1);

namespace BracketValidator\Validator;

use BracketValidator\BracketValidatorException;

class Length implements ValidatorInterface
{
    const MIN_LENGTH = 2;

    /**
     * @throws BracketValidatorException
     */
    public function validate(string $str): void
    {
        if (strlen($str) < self::MIN_LENGTH) {
            throw new BracketValidatorException(
                'Передана строка меньше минимально необходимой длины (' . self::MIN_LENGTH . ' симв.)'
            );
        }
    }
}