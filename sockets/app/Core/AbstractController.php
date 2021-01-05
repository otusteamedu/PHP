<?php

namespace App\Core;

use App\Api\ApplicationInterface;
use App\Api\ControllerInterface;
use App\Api\LoggerInterface;
use App\Api\ResponseInterface;
use App\Api\ViewInterface;
use App\Core\View;
use App\Core\WebApplication;
use http\Exception\BadUrlException;
use ReflectionMethod;

abstract class AbstractController implements ControllerInterface
{

    private AbstractApplication $app;

    public function __construct(AbstractApplication $application)
    {
        $this->app = $application;
    }

    protected function app(): AbstractApplication
    {
        return $this->app;
    }

    final public function execute(string $action): ?ResponseInterface
    {
        $method = $action.'Action';
        $reflection = new ReflectionMethod($this, $method);
        if (!$reflection->isPublic()) {
            throw new BadUrlException('Action is not found '.htmlspecialchars($method));
        }
        return $reflection->invoke($this);
    }

}