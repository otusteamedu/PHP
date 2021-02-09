<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\EmailDataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\IEmailDataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataSource\EmailDataSource;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\EmailValidator;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\IEmailValidator;
use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\Collections\StringObjects\CollectionStringObjects;
use Nlazarev\Hw2_1\Model\DataSource\IDataSource;

final class AppEmailValidation
{
    private static string $email_strings_file = "../in/emails.txt";
    private static IDataSource $email_strings_source;
    private static IEmailDataLoader $email_strings_loader;
    private static ICollectionGeneric $email_strings;
    private static IEmailValidator $email_validator;

    public static function run()
    {
        static::$email_strings = new CollectionStringObjects();
        static::$email_strings_source = new EmailDataSource(static::$email_strings_file);
        static::$email_strings_loader = new EmailDataLoader();
        static::$email_strings_loader->fromFileStrings(static::$email_strings_source);
        static::$email_strings_loader->toCollection(static::$email_strings);

        static::$email_validator = new EmailValidator();

        foreach (static::$email_strings as $key => $value) {
            echo $value->getValue() . ' ' . static::$email_validator->isStringObjectEmail($value) . PHP_EOL;
        }
    }
}
