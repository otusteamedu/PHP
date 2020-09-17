<?php


namespace Otus\Http\Controllers;


class Controller
{
    protected function post($status = 400)
    {
        $postString = $_POST['string'];
        $postLength = $_POST['Content-Length'];
        if (!empty($postString) && !empty($postLength) == strlen($postString)) {
            return $status = 200;
        } else {
            return $status;
        }
    }

    protected function response(int $status = 200): void
    {
        switch ($status) {
            case 200:
                $responseMessage = 'Строка корректна';
                break;
            case 400:
                $responseMessage = 'Строка некорректна';
                break;
            default:
                $responseMessage = 'Запрос некорректный, укажите строку или длину строки';
                $status = 422;
        }
        http_response_code($status);
        echo $responseMessage;
    }

}