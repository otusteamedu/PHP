<?php
declare(strict_types=1);

namespace BracketValidator\Validator;

use BracketValidator\BracketValidatorException;

interface ValidatorInterface
{
    /**
     * @throws BracketValidatorException
     */
    public function validate(string $str): void;
}