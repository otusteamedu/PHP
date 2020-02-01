<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Application;

class ExceptionHandler
{
    public static function errorHandler(\Throwable $e)
    {
        if (Application::getCurrent()->isDev() == 'dev') {
            $data = [
                'error' => "message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}"
            ];
        } else {
            $data = [
                'error' => 'Во время работы возникла ошибка. Обратитесь пожалуйста в тех.поддержку'
            ];
        }

        $response = new Response($data);
        $response->send();
    }
}