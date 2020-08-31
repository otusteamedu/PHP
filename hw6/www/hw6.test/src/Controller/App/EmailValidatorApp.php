<?php

namespace Nlazarev\Hw6\Controller\App;

use Noodlehaus\Config;
use Nlazarev\Hw6\Model\Email\EmailRegExp;
use Nlazarev\Hw6\Model\Email\EmailValidator;

abstract class EmailValidatorApp
{
    private static $params_json_path = 'config/app.json';
    private static $email_use_filter_var = false;
    private static $email_string = null;
    private static $email_validation_result = false;

    public static function init()
    {
        $conf = new Config(static::$params_json_path);
        static::$email_use_filter_var = $conf->get('app.use_filter_var');
        static::initEmailString();
//        static::$email_string = 'asnickolaz@gmail.com';
        $email_validator = new EmailValidator(static::$email_string);                

        if (!static::$email_use_filter_var) {
            $email_regexp = new EmailRegExp();
            $email_regexp->setFromJSONConf(static::$params_json_path);
            $email_validator->setEmailRegExp($email_regexp->getValue());            
        }

        static::$email_validation_result = $email_validator->validateString(static::$email_use_filter_var);
    }

    public static function setResultToHTTPHeader()
    {
        if (static::$email_validation_result) {
            header($_SERVER["SERVER_PROTOCOL"]." 200 OK", true, 200);
//            echo 200;
        } else {
            header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
//            echo 400;
        }
    }

    protected static function initEmailString()
    {
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") {
            if (!empty($_POST["email"])) {
                static::$email_string = $_POST["email"];
            }
        }
    }
}