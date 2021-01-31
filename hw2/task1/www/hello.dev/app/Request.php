<?php


namespace App;


abstract class Request
{
    /**
     * @return array
     */
    static function query(): array
    {
        $query['POST'] = $_POST;
        $query['GET'] = $_POST;

        return $query;
    }

    /**
     * @param $code
     * @return bool
     */
    static function response($code = 200): bool
    {
        switch ($code) {
            case 400 : {
                header('HTTP/1.1 400 Bad Request');
                break;
            }

            default : break;
        }

        return true;
    }
}