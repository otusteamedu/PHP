<?php

namespace crazydope\validation;

interface ValidatorInterface
{
    public function isValid( $value ): bool;

    public function getErrors(): array;
}