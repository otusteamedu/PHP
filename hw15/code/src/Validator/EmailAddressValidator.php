<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */


namespace APP\Validator;


class EmailAddressValidator
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function isValid(): bool
    {
        return $this->isValidFormat() && $this->hasValidMX();
    }

    private function isValidFormat(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function hasValidMX(): bool
    {
        $data = explode('@', $this->email);
        return getmxrr($data[1], $mxRecords);
    }
}