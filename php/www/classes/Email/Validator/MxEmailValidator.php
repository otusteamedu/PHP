<?php

namespace Classes\Email\Validator;

class MxEmailValidator  implements EmailValidator
{
    private $error;

    public function isValid(string $email): bool
    {
        $parts = explode('@', $email);

        if (!isset($parts[1])) {
            $this->error = sprintf('В переданном email: %s не найден host', $email);
            return false;
        }

        if (!checkdnsrr($parts[1], 'MX')) {
            $this->error = sprintf('Для %s не найдены записи DNS типа MX', $email);
            return false;
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->error;
    }
}
