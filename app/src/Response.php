<?php

namespace App;

class Response
{
    public static function send($code = 200, $message = '', $data = [])
    {

        http_response_code($code);
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);

        $data['status'] = $code < 300 ? "success" : "error";
        $data['message'] = $message;
        echo json_encode($data);
    }
}