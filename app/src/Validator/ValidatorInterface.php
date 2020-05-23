<?php

namespace Validator;

interface ValidatorInterface
{
    public function validate(string $emails);

    public function getViolation();
}
