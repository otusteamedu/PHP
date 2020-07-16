<?php

namespace App\Handlers;

class ControllerHandler
{
    private $routeConfig;
    private const CONTROLLER = 0;
    private const ACTION = 1;
    private const ARGUMENTS = 2;

    public function __construct(array $routeConfig) {
        $this->routeConfig = $routeConfig;
    }

    public function handle() {

        $controllerName = $this->getController($this->routeConfig);
        $actionName = $this->getAction($this->routeConfig);
        $controller = new $controllerName;
        $content = $controller->$actionName(...$this->getParams($this->routeConfig));

        return $content;
    }

    /**
     * @param array $routeInfo
     * @return string
     */
    private function getController(array $routeInfo): string {
        return 'App\Controllers\\' . $routeInfo[self::CONTROLLER];
    }

    /**
     * @param array $routeInfo
     * @return string
     */
    private function getAction(array $routeInfo): string {
        return $routeInfo[self::ACTION];
    }

    /**
     * @param array $routeInfo
     * @return array
     */
    private function getParams(array $routeInfo): array {
        return $routeInfo[self::ARGUMENTS];
    }


}