<?php

namespace EmailValidator;

use EmailValidator\Exceptions\AppException;

class EmailValidator {

    private array $emails;

    public function __construct()
    {
        if (empty($_POST['emails']) and !is_array($_POST['emails'])) {
            throw new AppException('something wrong with emails');
        }

        $this->emails = $_POST['emails'];
    }

    public function run()
    {
        foreach($this->emails as $email) {
            if (!$this->validEmail($email,true)){
                echo "$email is not a valid" . "\n";
            } else {
                echo "$email is a valid" . "\n";
            }
        }
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
