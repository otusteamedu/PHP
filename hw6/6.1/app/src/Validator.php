<?php


namespace App;


class Validator
{
    /**
     * @var array
     */
    private $mxHosts = [];
    /**
     * @var string
     */
    public $message;

    public function run(string $email): bool
    {
        if (empty($email)) {
            $this->message = "Email is empty";
            return false;
        }

        if (is_string($email) === false) {
            $this->message = "Email is not string";
            return false;
        }

        if ($this->validateRegEx($email) === false) {
            $this->message = "The string is not valid";
            return false;
        }

        if (filter_var(FILTER_VALIDATE_EMAIL) === false) {
            $this->message = "The string is not an email";
            return false;
        }

        if ($this->validateMX($email) === false) {
            $this->message = "Host {$this->getHostName($email)} has no MX records";
            return false;
        }
        $this->message = "Email {$email} is valid";

        return true;
    }

    private function validateRegEx(string $email): bool
    {
        $regEx = '/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/m';

        return preg_match_all($regEx, $email) ? true : false;
    }

    private function validateMX(string $email): bool
    {
        $hostName = $this->getHostName($email);

        return getmxrr($hostName, $this->mxHosts);
    }

    private function getHostName(string $email): string
    {
        return substr($email, stripos($email, '@')+1);
    }

    public function getMxRecords()
    {
        return $this->mxHosts;
    }
}