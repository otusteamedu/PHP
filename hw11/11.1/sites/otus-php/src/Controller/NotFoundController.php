<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;

class NotFoundController
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handler()
    {
        $errorUri = $this->app->request->get('uri');

        return new Response("Адрес {$errorUri} не доступен");
    }
}



