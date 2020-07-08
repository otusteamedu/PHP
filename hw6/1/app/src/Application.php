<?php

namespace Application;

use EmailVerifier\ErrorFormatter;
use EmailVerifier\EmailVerifier;
use EmailVerifier\Verifier\MX;
use EmailVerifier\Verifier\Spell;

class Application
{
    public function run(array $emails): array
    {
        $result = [];

        $emailVerifier = (new EmailVerifier)
            ->addVerifier(new Spell)
            ->addVerifier(new MX);

        foreach($emails as $email) {
            $errors = $emailVerifier->run($email);
            if (!empty($errors)) {
                $result[$email] = ErrorFormatter::format($errors, "%s\n");
                continue;
            }

            $result[$email] = 'Ok';
        }

        return $result;
    }
}