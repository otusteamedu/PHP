<?php

namespace App\EmailValidator;

use App\AppException;
use App\Request\Request;
use App\Response\Response;

class EmailValidator {

    private array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    public function validate()
    {
        $result = [];

        foreach($this->emails as $email) {
            if (!$this->validEmail($email,true)){
                $result[] = ["email" => $email, 'status' => 'invalid'];
            } else {
                $result[] = ["email" => $email, 'status' => 'valid'];
            }
        }

        Response::send(Response::OK, "email-ы проверены", $result);
    }

    private function validEmail(string $email, $extended = false)
    {
        if (empty($email)) {
            return false;
        }

        if (!preg_match('/^([a-z0-9_\'&\\.\\-\\+])+\\@(([a-z0-9\\-])+\\.)+([a-z0-9]{2,10})+$/i', $email)) {
            return false;
        }

        $domain = substr($email, strrpos($email, '@') + 1);
        $mxhosts = [];

        $checkDomain = getmxrr($domain, $mxhosts);

        if (!$checkDomain || empty($mxhosts)) {
            $dns = dns_get_record($domain, DNS_A);
            if (empty($dns)) {
                return false;
            }
        }

        return true;
    }
}