<?php

namespace App;

use Exception;
use Readers\RowsReader;
use Renderers\ValidationResultRenderer;
use Validators\EmailValidator;

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
            $validationResult = (new EmailValidator($email))->validate();

            echo (new ValidationResultRenderer($validationResult))->render();
        }
    }
}