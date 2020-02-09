<?php

namespace Core;

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
        $response = $this->app->getResponse();
        if ($this->app->getEnvironment()->isProduction()) {
            $response->setBody("Error {$error->getCode()}");
        } else {
            $response->setBody(
                "<{$this->app->getEnvironment()->getProfile()}>" . PHP_EOL
                . $error->__toString()
            );
        }
        $response->setHeaders(
            ["X-Error: {$this->app->getRequest()->getRequestStr()}"]
        )->flush($error->getCode());
    }

    /**
     * @param AppException $error
     */
    private function errorApp(AppException $error)
    {
        $response = $this->app->getResponse()->setStatusCode(500);
        if ($this->app->getEnvironment()->isProduction()) {
            $response->setBody("server couldn't handle request")->setHeaders(
                ["X-Error: AppError code: {$error->getCode()}"]
            );
        } else {
            $response->setBody($error->__toString());
        }
    }
}