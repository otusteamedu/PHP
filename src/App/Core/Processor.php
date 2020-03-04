<?php

namespace App\Core;

use Exception;

class Processor
{
    private Bootstrap $app;
    private Router $router;

    /**
     * AppProcessor constructor.
     * @param Bootstrap $app
     */
    public function __construct(Bootstrap $app)
    {
        $this->app = $app;
        $this->router = new Router($app->getRequest()->getRequestStr());
    }

    public function validateRequest()
    {
        if (!$this->router->handlerExists()) {
            $this->errorClient(new Exception('handler not found', 404));
        }
    }

    public function execute()
    {
        try {
            $this->router->runHandler($this->app);
        } catch (AppException $e) {
            $this->errorApp($e);
        }
        $this->app->getResponse()->flush();
    }

    /**
     * @param Exception $error
     */
    private function errorClient(Exception $error)
    {
        $env = new Environment();
        $response = $this->app->getResponse();
        if ($env->isProduction()) {
            $response->write('error ' . $error->getCode());
        } else {
            $response->write(
                $env->getProfile() . PHP_EOL . $error->getMessage()
            );
        }
        $response->setHeaders(
            ['x-error: ' . $this->app->getRequest()->getRequestStr()]
        )->flush($error->getCode());
    }

    /**
     * @param AppException $error
     */
    private function errorApp(AppException $error)
    {
        $env = new Environment();
        $response = $this->app->getResponse()->setStatusCode(500);
        if ($env->isProduction()) {
            $response->write('server couldn\'t handle request')->setHeaders(
                ['x-error: app error code: ' . $error->getCode()]
            );
        } else {
            $response->write($error->getCode() . ' ' . $error->getMessage());
        }
    }
}