<?php


namespace Otushw\Rules;

use Otushw\ListEmails;

class Checkmx extends Rule
{
    const AT = '@';

    public function execute(ListEmails $listEmails)
    {
        $emails = array_keys($listEmails->getListEmails());
        foreach ($emails as $email) {
            $hostname = substr($email, strpos($email, self::AT) + 1);
            $mxhosts = [];
            $value = getmxrr($hostname, $mxhosts);
            if ($value && !empty($mxhosts)) {
                $listEmails->setValidEmail($email);
            }
        }
    }
}