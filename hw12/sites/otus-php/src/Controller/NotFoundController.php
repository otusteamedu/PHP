<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;

class NotFoundController
{
    public function handler(): Response
    {
        $errorUri = Application::getCurrent()->request->get('uri');

        return new Response("Адрес {$errorUri} не доступен");
    }
}



