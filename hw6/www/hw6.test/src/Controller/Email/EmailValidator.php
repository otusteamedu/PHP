<?php

namespace Nlazarev\Hw6\Controller\Email;

use Noodlehaus\Config;
use Nlazarev\Hw6\Model\Email\EmailValidator as EmailValidatorModel;

abstract class EmailValidator
{
    private static $params_json_path = 'config/email_validator.json';
    private static $conf = null;
    private static $email_string = null;
    private static $email_regexp_params = array();
    private static $email_use_filter_var = false;
    private static $email_validation_result = false;

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

    public static function init()
    {
        static::$conf = new Config(static::$params_json_path);
        static::initEmailRegExp();
        static::initEmailString();

//        static::$email_string = 'asnickolaz@gmail.com';
        $email = new EmailValidatorModel(static::$email_string);
        $email->setEmailRegExp(static::$email_regexp_params['prep_string']);
        static::$email_use_filter_var = static::$conf->get('app.use_filter_var');
        static::$email_validation_result = $email->validateString(static::$email_use_filter_var);

//        var_dump(static::$email_regexp_params['prep_string']);
    }

    protected static function initEmailString()
    {
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") {
            if (!empty($_POST["email"])) {
                static::$email_string = $_POST["email"];
            }
        }
    }

    protected static function initEmailRegExp()
    {
        static::$email_regexp_params = array(
            'patern' => static::$conf->get('app.email_regexp.patern'),
            'spec_symb_string' => static::getEmailRegExpSpecSymbString(static::$conf->get('app.email_regexp.options.spec_symb')),
            'unicode_symb_string' => static::getEmailRegExpUnicodeSymbString(static::$conf->get('app.email_regexp.options.unicode_symb'))
        );
        
        $email_regexp_string = str_replace('{{spec_symb}}',
                                            static::$email_regexp_params['spec_symb_string'],
                                            static::$email_regexp_params['patern']);
        $email_regexp_string = str_replace('{{unicode}}',
                                            static::$email_regexp_params['unicode_symb_string'],
                                            $email_regexp_string);
        static::$email_regexp_params['prep_string'] = $email_regexp_string;
    }

    protected static function getEmailRegExpSpecSymbString(array $options_spec_symb): string
    {
        $spec_symb_string = "";

        foreach ($options_spec_symb as $key => $value) {
            if ($value['usage'] == 1) {
                $spec_symb_string .= $value['string'];
            }
        }

        return $spec_symb_string;
    }

    protected static function getEmailRegExpUnicodeSymbString(array $options_unicode_symb): string
    {
        $unicode_symb_string = "";

        foreach ($options_unicode_symb as $key => $value) {
            if ($value['usage'] == 1) {
                $unicode_symb_string .= $value['string'];
            }
        }

        return $unicode_symb_string;
    }
}