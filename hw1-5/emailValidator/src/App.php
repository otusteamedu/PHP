<?php

namespace Src;

/**
 * Class App
 *
 * @package Src
 */
class App
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $parser = new Parser($_ENV['FILE_PATH']);
        $emails = $parser->parse();
        foreach ($emails as $email) {
            $emailValidator = new EmailValidator($email);
            if ($emailValidator->isValid()) {
                echo "Email - {$email} is valid" . PHP_EOL;
            } else {
                echo "Email - {$email} is\'not valid" . PHP_EOL;
            }
        }
    }
}