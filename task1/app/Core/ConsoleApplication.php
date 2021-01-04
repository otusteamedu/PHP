<?php

namespace App\Core;

use App\Api\ConfigInterface;
use App\Api\ControllerInterface;
use App\Api\RequestInterface;
use App\Api\ResponseInterface;
use Exception;
use http\Exception\BadUrlException;
use ReflectionClass;

class ConsoleApplication extends AbstractApplication
{

    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config);
    }

    public function run(): void
    {
        try {
            $requestString = $_SERVER['argv'][1] ?? '';
            [$controllerName, $actionName] = $this->parseControllerAction($requestString);
            $controller = $this->determineController($controllerName);
            $controller->execute($actionName);
        } catch (Exception $exception) {
            print 'Internal Server Error. '.$exception->getMessage().PHP_EOL.$exception->getTraceAsString().PHP_EOL;

        }
    }

    protected function controllerDirectory(): string
    {
        return 'Command';
    }

}