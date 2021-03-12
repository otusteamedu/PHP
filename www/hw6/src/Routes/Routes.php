<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Routes;

use League\Route\Router;

class Routes
{
    private static Routes $instance;
    private Router $router;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Routes
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
            self::$instance->router = new Router();
        }

        return self::$instance;
    }

    public function getRouter(): Router
    {
        return self::$instance->router;
    }
    
    public function initArticleRoutes()
    {
        self::$instance->router->map('GET', '/articles/news/add/html', 'Nlazarev\Hw6\Controller\Articles::addNews');
        self::$instance->router->map('GET', '/articles/news/add/xml', 'Nlazarev\Hw6\Controller\Articles::addNews');
        self::$instance->router->map('GET', '/articles/news/add/json', 'Nlazarev\Hw6\Controller\Articles::addNews');

        self::$instance->router->map('GET', '/articles/review/add/html', 'Nlazarev\Hw6\Controller\Articles::addReview');
        self::$instance->router->map('GET', '/articles/review/add/xml', 'Nlazarev\Hw6\Controller\Articles::addReview');
        self::$instance->router->map('GET', '/articles/review/add/json', 'Nlazarev\Hw6\Controller\Articles::addReview');
    }
}
