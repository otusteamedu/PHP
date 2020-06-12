<?php

namespace App\Core;

use App\Api\ApplicationInterface;
use App\Api\ControllerInterface;
use App\Api\ViewInterface;
use App\Core\View;
use App\Core\WebApplication;
use http\Exception\BadUrlException;
use ReflectionMethod;

abstract class BaseWebController implements ControllerInterface
{

    private WebApplication $app;

    public function __construct(WebApplication $application)
    {
        $this->app = $application;
    }

    final public function execute(string $action): ViewInterface
    {
        $method = $action.'Action';
        $reflection = new ReflectionMethod($this, $method);
        if (!$reflection->isPublic()) {
            throw new BadUrlException('Action is not found '.htmlspecialchars($method));
        }
        return $reflection->invoke($this);
    }

    protected function app(): WebApplication
    {
        return $this->app;
    }

    protected function view(string $viewName, ?array $parameters = []): View
    {
        $reflection = new \ReflectionClass($this);
        $controllerName = $reflection->getShortName();
        $pos = strrpos($controllerName, 'Controller');
        if ($pos === false) {
            throw new \Exception('Invalid controller name '.$controllerName);
        }
        $route = substr(strtolower($controllerName), 0, $pos);
        return (new View($route.'/'.$viewName))
            ->setParameters($parameters);
    }
}