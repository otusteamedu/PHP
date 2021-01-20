<?php

namespace App;

use Exception;
use Readers\RowsReader;
use Validators\EmailMXValidator;
use Validators\EmailPatternValidator;
use Validators\EmptyStringValidator;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * run the app
     *
     * @throws Exception
     */
    public function run (): void
    {
        $filePath = '../files/emails.txt';
        $rows     = (new RowsReader($filePath))->read();

        foreach ($rows as $email) {
            $email = trim($email);

            $validator = new EmptyStringValidator();
            $validator->linkWith(new EmailPatternValidator())
                      ->linkWith(new EmailMXValidator());

            echo 'checking ' . $email . PHP_EOL;

            if ($validator->check($email) === true) {
                echo $email . ' is valid' . PHP_EOL;
            }
        }
    }
}