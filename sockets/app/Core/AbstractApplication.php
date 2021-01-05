<?php

namespace App\Core;

use App\Api\ApplicationInterface;
use App\Api\ConfigInterface;
use App\Api\ControllerInterface;
use App\Api\LoggerInterface;
use http\Exception\BadUrlException;
use ReflectionClass;

abstract class AbstractApplication implements ApplicationInterface
{
    protected ConfigInterface $config;

    public function __construct(string $configFile)
    {
        $config = (new ConfigIni())->loadFile($configFile);
        $this->config = $config;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    abstract public function run(): void;

    abstract public function logger(): LoggerInterface;


    /**
     * @param string $controllerName
     * @return ControllerInterface
     */
    protected function determineController(string $controllerName): ControllerInterface
    {
        $controllerPath = implode('\\', array_map(function ($part) {
            return ucfirst($part);
        }, explode('/', $controllerName)));
        $className = 'App\\'.$this->controllerDirectory().'\\'.$controllerPath.'Controller';
        $reflection = new ReflectionClass($className);
        if ($reflection->implementsInterface(ControllerInterface::class)) {
            /** @var ControllerInterface $controller */
            $controller = $reflection->newInstance($this);
            return $controller;
        } else {
            throw new BadUrlException('Controller is not found '.htmlspecialchars($controllerName));
        }
    }

    abstract protected function controllerDirectory(): string;

    /**
     * @param $requestString
     * @return array [$controllerName, $actionName]
     */
    protected function parseControllerAction($requestString)
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

}