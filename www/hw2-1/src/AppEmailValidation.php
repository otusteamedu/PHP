<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\AppEmailValidation\Config\Config;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Config\IConfig;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\DataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader\IDataLoader;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataSource\DataSource;
use Nlazarev\Hw2_1\Model\AppEmailValidation\DataSource\IDataSource;
use Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp\IRegExp;
use Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp\RegExp;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\IValidator;
use Nlazarev\Hw2_1\Model\AppEmailValidation\Validator\Validator;
use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\Collections\StringObjects\CollectionStringObjects;
use Nlazarev\Hw2_1\Model\File\FileStrings;

final class AppEmailValidation
{
    private static string $email_strings_init = "../in/emails.txt";
    private static string $conf_init = "../config/email_validation.json";
    private static IConfig $conf;
    private static IDataSource $email_strings_source;
    private static IDataLoader $email_strings_loader;
    private static ICollectionGeneric $email_strings;
    private static IValidator $email_validator;
    private static IRegExp $email_regexp;

    public static function run(string $conf_init = "../config/email_validation.json")
    {
        static::$conf_init = $conf_init;
        static::$conf = new Config();
        static::$conf->fromFile(new FileStrings(static::$conf_init));
        static::$email_regexp = new RegExp(null);
        static::$email_regexp->fromConfig(static::$conf);
        static::$email_strings_init = static::$conf->getValueByKey("app.email_source.file_path");

        static::$email_strings = new CollectionStringObjects();
        static::$email_strings_source = new DataSource();
        static::$email_strings_source->fromFile(new FileStrings(static::$email_strings_init));
        static::$email_strings_loader = new DataLoader();
        static::$email_strings_loader->setDataSourceAsFile(static::$email_strings_source);
        static::$email_strings_loader->load();
        static::$email_strings_loader->toCollection(static::$email_strings);

        static::$email_validator = new Validator();

        //        echo static::$regexp->getValue() . PHP_EOL;

        foreach (static::$email_strings as $key => $value) {
            echo ($value->getValue() . ' ' .
                (static::$email_validator->isStringObjectEmail($value) ? '[Valid]' : '[Not Valid]') . ' ' .
                (static::$email_validator->isValidToRegExpStringObject($value, static::$email_regexp) ? '[Valid]' : '[Not Valid]') . PHP_EOL);
        }
    }
}
