<?php

namespace Src;

class Parser
{
    public function parseList($list) {
        $list = explode(PHP_EOL, $list);
        $valid_emails = [];
        foreach ($list as $email) {
            $res = $this->validateEmail($email);
            if ($res == true) {
                $valid_emails[] = $email . PHP_EOL;
            }
        }
        return $valid_emails;
    }

    protected function validateEmail($email) {
        $domain =  preg_replace('/^.+?@/', '', $email);
        return filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr($domain, 'MX');
    }
}