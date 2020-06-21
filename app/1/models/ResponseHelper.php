<?php


namespace models;


class ResponseHelper
{
    public static function sendOk($message)
    {
        header("HTTP/1.1 200 OK");
        echo $message;
    }

    public static function sendError($message)
    {
        header("HTTP/1.1 400 Bad Request");
        echo $message;
    }

}