<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;
use Nlazarev\Hw2_1\Model\General\String\StringObject;
use Nlazarev\Hw2_1\Model\Validators\StringObject\IValidatorStringObjectIsBracketsString;
use Nlazarev\Hw2_1\Model\Validators\StringObject\ValidatorStringObjectIsBracketsString;
use Psr\Http\Message\ServerRequestInterface;

final class AppServerBrackets
{
    private static IStringObject $brackets_string;
    private static IValidatorStringObjectIsBracketsString $validator;

    public static function run()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["string"])) {
                static::$brackets_string = new StringObject($_POST["string"]);
            }
        }

        //        static::$brackets_string = new StringObject('(())()');

        static::$validator = new ValidatorStringObjectIsBracketsString();

        if (static::$validator->isStringObjectBalancedBracketsString(static::$brackets_string)) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 404 Not Found");
        }
    }
}
