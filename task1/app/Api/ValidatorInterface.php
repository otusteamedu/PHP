<?php

namespace App\Api;

interface ValidatorInterface
{
    /**
     * @param mixed $input
     * @return bool
     */
    public function validate($input): bool;

}