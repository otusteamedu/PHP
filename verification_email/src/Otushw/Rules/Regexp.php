<?php

namespace Otushw\Rules;

use Otushw\ListEmails;

class Regexp extends Rule
{
    const PATTERN = "/^(?:[A-Za-z0-9]+(?:[-_.+]?[A-Za-z0-9-_.+#$%^&*]+)?" .
    "@[A-Za-z0-9]+(?:\.?[A-Za-z0-9-.]+)?\.[A-Za-z]{2,10})$/i";

    public function execute(ListEmails $listEmails)
    {
        $emails = array_keys($listEmails->getListEmails());
        foreach ($emails as $email) {
            if (preg_match(self::PATTERN, $email)) {
                $listEmails->setValidEmail($email);
            }
        }
    }
}