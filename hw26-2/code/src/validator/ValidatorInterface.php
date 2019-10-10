<?php

namespace TimGa\hw26\validator;

interface ValidatorInterface
{
    public function isValid($value): bool;

}
