<?php

namespace App\Core;

use App\Core\ConfigInterface;
use App\Controller\ControllerInterface;
use App\Core\LoggerInterface;
use App\Core\RequestInterface;
use App\Core\ResponseInterface;
use App\Core\ConsoleLogger;
use Exception;
use http\Exception\BadUrlException;
use ReflectionClass;

class ConsoleApplication extends AbstractApplication
{

    private LoggerInterface $logger;

    public function __construct(string $configFile)
    {
        parent::__construct($configFile);
        $this->logger = new ConsoleLogger();
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

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

}