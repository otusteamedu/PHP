<?php

namespace App\Core;

use App\Api\ConfigInterface;
use App\Api\ControllerInterface;
use App\Api\RequestInterface;
use App\Api\ResponseInterface;
use Exception;
use http\Exception\BadUrlException;
use ReflectionClass;

class WebApplication extends BaseApplication
{
    protected HttpRequest $request;
    protected HttpResponse $response;

    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config);
        $this->request = new HttpRequest();
        $this->response = new HttpResponse();
    }

    public function run(): void
    {
        try {
            $requestString = $this->request->getQuery('r', '');
            [$controllerName, $actionName] = $this->parseControllerAction($requestString);
            $controller = $this->determineController($controllerName);
            $view = $controller->execute($actionName);
            $this->response->setBody($view->render());
        } catch (Exception $exception) {
            $message = 'Internal Server Error. '.$exception->getMessage().PHP_EOL.$exception->getTraceAsString();
            $this->response->setBody($message)->setHttpCode(500);
        }
        $this->response->send();
    }

    /**
     * @param string $controllerName
     * @return ControllerInterface
     */
    private function determineController(string $controllerName): ControllerInterface
    {
        $controllerPath = implode('\\', array_map(function ($part) {
            return ucfirst($part);
        }, explode('/', $controllerName)));
        $className = 'App\\Controller\\'.$controllerPath.'Controller';
        $reflection = new ReflectionClass($className);
        if ($reflection->implementsInterface(ControllerInterface::class)) {
            /** @var ControllerInterface $controller */
            $controller = $reflection->newInstance($this);
            return $controller;
        } else {
            throw new BadUrlException('Controller is not found '.htmlspecialchars($controllerName));
        }
    }

    /**
     * @param $requestString
     * @return array [$controllerName, $actionName]
     */
    private function parseControllerAction($requestString)
    {
        $elements = explode('/', $requestString);
        if (!$elements || !$requestString) {
            $controllerName = 'index';
            $actionName = 'index';
        } elseif (count($elements) === 1) {
            $controllerName = current($elements);
            $actionName = 'index';
        } else {
            $controllerName = $elements[0];
            $actionName = $elements[1];
        }
        return [$controllerName, $actionName];
    }

    public function getRequest(): HttpRequest
    {
        return $this->request;
    }

    public function getResponse(): HttpResponse
    {
        return $this->response;
    }
}