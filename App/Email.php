<?php
namespace Ozycast\App;

class Email
{
    public $email;
    public $domain;
    private $error = [];

    public function __construct($email)
    {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$)/i", $email, $EmailSplit))
            return;

        $this->domain = $EmailSplit[2];
        $this->email = $email;
    }

    public function getError()
    {
        return !empty($this->error) ? $this->error[0] : "";
    }

    public function check()
    {
        $this->checkPregMatch();
        $this->checkDNS();

        if (!empty($this->error))
            return 0;

        return 1;
    }

    public function checkDNS()
    {
        if ($this->domain && !checkdnsrr($this->domain))
            $this->error[] = "DNS record not found";
    }

    public function checkPregMatch()
    {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $this->email))
            $this->error[] = "email incorrect";
    }
}