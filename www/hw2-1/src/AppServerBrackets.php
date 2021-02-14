<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;
use Nlazarev\Hw2_1\Model\General\String\StringObject;
use Nlazarev\Hw2_1\Model\Validators\StringObject\IValidatorStringObjectIsBracketsString;
use Nlazarev\Hw2_1\Model\Validators\StringObject\ValidatorStringObjectIsBracketsString;

final class AppServerBrackets
{
    private static IStringObject $brackets_string;
    private static IValidatorStringObjectIsBracketsString $validator;

    public static function run()
    {
        $request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );

        if ($request->getMethod() == 'POST') {
            if ($request->hasHeader('content-type')) {
                if ($request->getHeaderLine('content-type') == 'application/x-www-form-urlencoded') {
                    if (!empty($request->getParsedBody()['string'])) {
                        static::$brackets_string = new StringObject($request->getParsedBody()['string']);
                    }
                }
            }
        }

        //        static::$brackets_string = new StringObject('(())(');

        static::$validator = new ValidatorStringObjectIsBracketsString();

        $response = (new \Laminas\Diactoros\Response());

        if (static::$validator->isStringObjectBalancedBracketsString(static::$brackets_string)) {
            //                                    header("HTTP/1.1 200 OK");
            $response = $response->withStatus(200);
        } else {
            //                                    header("HTTP/1.1 404 Not Found");
            $response = $response->withStatus(404);
        }

        $emiter = new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter();
        $emiter->emit($response);
    }
}
