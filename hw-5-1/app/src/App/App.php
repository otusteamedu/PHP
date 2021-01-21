<?php

namespace App;

use Config\Config;
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
    private const EMAIL_LIST_CONFIG_KEY = 'email_list_path';

    /**
     * run the app
     *
     * @throws Exception
     */
    public function run (): void
    {
        $config   = new Config();
        $filePath = $config->getItem(self::EMAIL_LIST_CONFIG_KEY);
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