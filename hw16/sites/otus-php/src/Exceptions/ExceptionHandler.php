<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Kernel\Application;
use App\Kernel\Response;
use ReflectionException;
use Throwable;

class ExceptionHandler
{
    /**
     * @param Throwable $e
     * @throws KernelException
     * @throws ReflectionException
     */
    public static function errorHandler(Throwable $e)
    {
        if (Application::getInstance()->isDev() == 'dev') {
            $exceptionClass = get_class($e);
            $data = [
                'error' => "{$exceptionClass}: {message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()};"
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