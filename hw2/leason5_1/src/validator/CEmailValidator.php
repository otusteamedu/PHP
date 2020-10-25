<?php

namespace validator;

class CEmailValidator extends CBaseValidator
{
    /**
     * @var string Regex pattern for validate
     */
    public $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    /**
     * @var bool Check MX DNS record
     */
    public $checkMX = false;


    /**
     * Validate value
     *
     * @param string $value
     *
     * @return bool
     */
    public function validate($value)
    {
        parent::validate($value);

        return $this->checkByPattern($value) && $this->checkMX($value);
    }


    /**
     * Check MX DNS record
     *
     * @param $value
     *
     * @return bool
     */
    private function checkMX($value)
    {
        if ( ! $this->checkMX) {
            return true;
        }
        $domain = rtrim(substr($value, strpos($value, '@') + 1), '>');
        $result = checkdnsrr($domain, 'MX');
        if ($result === false) {
            $this->setError("Error validate MX DNS record for  $domain");
        }

        return $result;
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
        $result = preg_match($this->pattern, $email);
        if ($result === false) {
            $this->setError('Error pattern validate');
        }

        return $result;
    }
}
