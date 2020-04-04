<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Kernel\Response;
use ReflectionException;

class NotFoundController implements ControllerInterface
{
    /**
     * @throws ReflectionException
     * @throws KernelException
     */
    public function handler()
    {
        $request = Application::getInstance('request');
        $errorUri = $request->get('uri');

        $response = new Response("Адрес {$errorUri} не доступен");

        $response->send();
    }
}
