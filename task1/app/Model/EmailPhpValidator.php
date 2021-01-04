<?php

namespace App\Model;

use App\Api\ValidatorInterface;

class EmailPhpValidator implements ValidatorInterface
{
    /**
     * @param string $input
     * @return bool
     */
    public function validate($input): bool
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }

}