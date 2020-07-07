<?php
declare(strict_types=1);

namespace BracketValidator\Validator;

use BracketValidator\BracketValidatorException;

class Even implements ValidatorInterface
{
    /**
     * @throws BracketValidatorException
     */
    public function validate(string $str): void
    {
        $length = strlen($str);
        if (  $length % 2 !== 0) {
            throw new BracketValidatorException(
                'Передана строка с нечетным количеством символов'
            );
        }
    }
}