<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\AppEmailValidation\Config\EmailConfig;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Config\IEmailConfig;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\EmailDataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\IEmailDataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataSource\EmailDataSource;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataSource\IEmailDataSource;
use Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp\EmailRegExp;
use Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp\IEmailRegExp;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\EmailValidator;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\IEmailValidator;
use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\Collections\StringObjects\CollectionStringObjects;

final class AppEmailValidation
{
    private static string $email_strings_file = "../in/emails.txt";
    private static string $conf_path = "../config/email_validation.json";
    private static IEmailDataSource $email_strings_source;
    private static IEmailDataLoader $email_strings_loader;
    private static ICollectionGeneric $email_strings;
    private static IEmailValidator $email_validator;
    private static IEmailConfig $conf;
    private static IEmailRegExp $regexp;

    public static function run()
    {
        static::$email_strings = new CollectionStringObjects();
        static::$email_strings_source = new EmailDataSource(static::$email_strings_file);
        static::$email_strings_loader = new EmailDataLoader();
        static::$email_strings_loader->fromFileStrings(static::$email_strings_source);
        static::$email_strings_loader->toCollection(static::$email_strings);

        static::$email_validator = new EmailValidator();
        static::$conf = new EmailConfig(static::$conf_path);
        static::$regexp = new EmailRegExp(null);
        static::$regexp->fromConfig(static::$conf);

        //        echo static::$regexp->getValue() . PHP_EOL;

        foreach (static::$email_strings as $key => $value) {
            echo($value->getValue() . ' ' .
                (static::$email_validator->isStringObjectEmail($value) ? '[Valid]' : '[Not Valid]') . ' ' .
                (static::$email_validator->isValidToRegExpStringObject($value, static::$regexp) ? '[Valid]' : '[Not Valid]') . PHP_EOL);
        }
    }
}
