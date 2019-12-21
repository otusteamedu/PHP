<?php

declare(strict_types=1);

use MailChecker\DefaultMailCheckerTrait;

class App
{
    use DefaultMailCheckerTrait;

    public function run(string $email)
    {
        $errors = $this->checkEmail($email);

        if (count($errors) === 0) {
            echo "Email $email валиден";
        } else {
            foreach ($errors as $error) {
                echo $error . '<br />';
            }
        }
    }
}
