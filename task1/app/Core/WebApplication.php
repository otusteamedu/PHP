<?php

namespace App\Core;

use App\Api\ConfigInterface;
use App\Api\ControllerInterface;
use App\Api\RequestInterface;
use App\Api\ResponseInterface;
use Exception;
use http\Exception\BadUrlException;
use ReflectionClass;

class WebApplication extends AbstractApplication
{
    protected HttpRequest $request;

    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config);
        $this->request = new HttpRequest();
    }

    public function run(): void
    {
        try {
            $requestString = $this->request->getQuery('r', '');
            [$controllerName, $actionName] = $this->parseControllerAction($requestString);
            $controller = $this->determineController($controllerName);
            $response = $controller->execute($actionName);
            if ($response) {
                $response->setBody($response->getView()->render());
                $response->send();
            }
        } catch (Exception $exception) {
            $message = 'Internal Server Error. '.$exception->getMessage().PHP_EOL.$exception->getTraceAsString();
            (new HttpResponse())->setBody($message)->setHttpCode(500)->send();
        }
    }

    protected function controllerDirectory(): string
    {
        return 'Controller';
    }

    public function getRequest(): HttpRequest
    {
        return $this->request;
    }
}