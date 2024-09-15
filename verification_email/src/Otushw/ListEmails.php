<?php


namespace Otushw;


class ListEmails
{
    protected $listEmails;

    public function __construct(array $listEmails)
    {
        foreach ($listEmails as $email) {
            $this->listEmails[$email] = false;
        }
    }

    public function getListEmails()
    {
        return $this->listEmails;
    }

    public function setValidEmail($email)
    {
        $this->listEmails[$email] = true;
    }



}