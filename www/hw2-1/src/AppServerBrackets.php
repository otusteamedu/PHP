<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\Validators\ValidatingStringBrackets;

class AppServerBrackets
{
    private static $brackets_string = "(())(";

    public static function run()
    {
        if (($_SERVER["REQUEST_METHOD"] ?? "GET") == "POST") {
            if (!empty($_POST["string"])) {
                static::$brackets_string = $_POST["string"];
            }
        }

        $brackets = new ValidatingStringBrackets(static::$brackets_string);

        if ($brackets->validate()) {
            header("HTTP/1.1 200 OK");;
        } 
            
        header("HTTP/1.1 404 Not Found");;
    }
}
