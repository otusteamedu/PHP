<?php

namespace App\Validator;

/**
 * Interface Validator
 */
interface Validator
{
    /**
     * @param $val
     * @return bool
     */
    public function isValid($val): bool;

}
