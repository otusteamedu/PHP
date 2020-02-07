<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Controller\IndexController;
use App\Controller\LazyLoadController;
use App\Controller\NotFoundController;
use Exception;

class Router implements RouterInterface
{
    public $request;

    /**
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function findController(): string
    {
        if (preg_match('~^/lazy_load[/]?$~', $this->request->get('uri'))) {

            $controller = LazyLoadController::class;

        } elseif (preg_match('~^/$~', $this->request->get('uri'))) {

            $controller = IndexController::class;

        } else {

            $controller = NotFoundController::class;

        }

        return $controller;
    }
}