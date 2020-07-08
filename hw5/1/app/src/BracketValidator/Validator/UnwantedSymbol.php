<?php
declare(strict_types=1);

namespace BracketValidator\Validator;

use BracketValidator\BracketValidator;
use BracketValidator\BracketValidatorException;

class UnwantedSymbol implements ValidatorInterface
{
    /**
     * @throws BracketValidatorException
     */
    public function validate(string $str): void
    {
        if (preg_match('/[^' . BracketValidator::ALLOWED_SYMBOLS . ']/',$str)) {
            throw new BracketValidatorException(
                'В строке присутствуют символы отличные от поддерживаемого типа скобок'
            );
        }
    }
}