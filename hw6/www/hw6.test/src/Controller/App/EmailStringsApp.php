<?php

namespace Nlazarev\Hw6\Controller\App;

use Nlazarev\Hw6\Model\Email\EmailString;
use Nlazarev\Hw6\Model\Email\EmailStrings;

abstract class EmailStringsApp
{
    private static $email_strings_file = "email-strings/in.txt";
    private static $email_strings_validator_URL = "http://192.168.137.60:8080/email_validator.php";

    public static function init()
    {
        $email_strings = new EmailStrings();
        if ($email_strings->setEmailStringsFromFile(static::$email_strings_file)) {
            foreach ($email_strings->getEmailStrings() as &$email_string) {
                $email_string->validateOverPOSTRequest(static::$email_strings_validator_URL);
                echo $email_string->getValue() .
                    " - " .
                    (($email_string->isValid()) ? "Valid" : "Not valid") . 
                    "<br>";
            }
        } else {
            echo "Email strings not initialized";
        }
    }

}