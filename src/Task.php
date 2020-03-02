<?php

namespace App;

use App\EmailValidator\DNSCheckValidation;
use App\EmailValidator\EmailValidator;
use App\EmailValidator\RegexValidation;

class Task
{
    public static function run(): void
    {
        global $argv;
        $emails = [];

        if (isset($argv[1])) {
            $emails[$argv[1]] = false;
        } else {
            while (!feof(STDIN)) {
                $mail = trim(fgets(STDIN));
                if ($mail) {
                    $emails[$mail] = false;
                }
            }
        }

        $validator = new EmailValidator();
        foreach (array_keys($emails) as $mail) {
            $emails[$mail] = $validator->isValid($mail, [DNSCheckValidation::class, RegexValidation::class]);
        }

        echo json_encode($emails, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        echo PHP_EOL;
    }
}
