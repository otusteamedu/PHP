<?php

namespace Service\Core\Validator\Rules;

use Service\Core\Validator\RuleInterface;

class Email implements RuleInterface
{
    public function validate($input): bool
    {
        return $this->checkFormat($input) && $this->checkMXRecord($input);
    }

    public function getInvalidMessage(string $field): string
    {
        return sprintf('Field %s contains invalid email format', $field);
    }

    private function checkFormat(string $email) : bool
    {
        return filter_var( $email, FILTER_VALIDATE_EMAIL ) &&
            preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $email);
    }

    private function checkMXRecord(string $email) : bool
    {
        $splitEmail = explode('@', $email);
        return getmxrr(array_pop($splitEmail), $hosts);
    }
}