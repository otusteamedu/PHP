<?php

namespace validator;

class CEmailValidator implements IValidator
{
    /**
     * @var string Regex pattern for validate
     */
    public $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    /**
     * @var bool Check MX DNS record
     */
    public $checkMX = true;


    /**
     * Validate value
     *
     * @param string $value
     *
     * @return bool
     */
    public function validate($value)
    {
        return $this->checkByPattern($value) && $this->checkMX($value);
    }


    /**
     * Check MX DNS record
     *
     * @param $email
     *
     * @return bool
     */
    private function checkMX($email)
    {
        if ( ! $this->checkMX) {
            return true;
        }
        $domain = rtrim(substr($email, strpos($email, '@') + 1), '>');

        return checkdnsrr($domain, 'MX');
    }


    /**
     * Validate email address by regex pattern
     *
     * @param $email
     *
     * @return false|int
     */
    private function checkByPattern($email)
    {
        return preg_match($this->pattern, $email);
    }
}
