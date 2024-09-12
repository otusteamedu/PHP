<?php


namespace HW\validators;


class ValidatorDns extends Validator
{
    private $recordType;

    public function __construct($recordType = 'MX')
    {
        $this->recordType = $recordType;
    }

    protected function getHost($email)
    {
        $domen = end(explode('@', $email));
        $host = gethostbyname($domen);
        return $host == $domen ? false: $host;
    }

    public function validate($email)
    {
        $host = $this->getHost($email);
        if (!$host)
            return false;

        return checkdnsrr($host, $this->recordType) != FALSE;
    }

}