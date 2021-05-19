<?php

namespace Service\Core\Validator;

interface RuleInterface
{
    public function getInvalidMessage(string $field) : string;

    /**
     * @param mixed $input
     * @return bool
     */
    public function validate($input) : bool;
}