<?php

namespace timga\emailValidator;

class EmailValidator
{
    private $email;
    private $emailNamePart;
    private $emailHostPart;
    private $mxRecords;
    private $errors;

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function validate(): bool
    {
        $errors = [];
        if (!$this->isValidEmail()) {
            $errors[] = "Email is not valid";
        }
        if (!$this->isValidMxRecord()) {
            $errors[] = "MX record for hostname not found";
        }
        $this->errors = $errors;
        if (empty($errors)) {
            return true;
        }
        return false;
    }

    private function isValidEmail(): bool
    {
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if ((preg_match($pattern, $this->email))) {
            return true;
        }
        return false;
    }

    private function isValidMxRecord(): bool
    {
        if (!$this->splitEmail()) {
            return false;
        }
        if (getmxrr($this->emailHostPart, $mxRecords)) {
            $this->mxRecords = $mxRecords;
            return true;
        }
        return false;
    }

    private function splitEmail(): bool
    {
        $emailParts = explode('@', $this->email);
        if (count($emailParts) == 2) {
            $this->emailNamePart = $emailParts[0];
            $this->emailHostPart = $emailParts[1];
            return true;
        }
        return false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getMxRecords()
    {
        return $this->mxRecords;
    }
}
