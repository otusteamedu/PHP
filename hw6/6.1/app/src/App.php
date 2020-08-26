<?php


namespace App;


use Exception;

class App
{

    public function run(array $emails)
    {
        $validator = new Validator();
        if (empty($emails)) {
            throw new Exception('Emails list is empty');
        }

        foreach ($emails as $email) {
            $validator->run($email);

            echo $validator->message.PHP_EOL;
        }
    }
}