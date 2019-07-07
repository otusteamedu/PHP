<?php

namespace App;

interface EmailValidatorInterface
{
    /**
     * @return bool
     * @throws ValidatorInternalError
     */
    public function execute();
}
