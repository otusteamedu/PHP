<?php

namespace App\Core;

use App\Api\LoggerInterface;
use Exception;

class WebApplication extends AbstractApplication
{
    protected HttpRequest $request;
    protected LoggerInterface $logger;

    public function __construct(string $configFile)
    {
        parent::__construct($configFile);
        $this->request = new HttpRequest();
        $this->logger = new FileLogger();
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

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }
}