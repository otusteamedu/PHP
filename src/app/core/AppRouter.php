<?php

namespace Core;

use Controller\AppController;

class AppRouter
{
    /** @var AppNode $node */
    private AppNode $node;

    /** @var AppController $controller */
    private AppController $controller;

    /** @var AppNode[] $routes */
    private static array $routes = [];

    /** @var string $viewsPath */
    private static string $viewsPath = "";

    /**
     * AppRouter constructor.
     * @param string $requestStr
     */
    public function __construct(string $requestStr)
    {
        $this->node = self::$routes[$requestStr] ?? new AppNode();
    }

    /**
     * @param string $routesFilePath
     */
    public static function setRoutesFromFile(string $routesFilePath)
    {
        if (file_exists($routesFilePath)) {
            $nodeRows = json_decode(file_get_contents($routesFilePath), JSON_OBJECT_AS_ARRAY);
            if (is_array($nodeRows)) {
                foreach ($nodeRows as $nodeRow) {
                    $node = new AppNode($nodeRow);
                    self::$routes[$node->getRequest()] = $node;
                }
            }
        }
    }

    /**
     * @param AppConfig   $appConfig
     * @param AppResponse $appResponse
     * @throws AppException
     */
    public function initAppController(AppConfig $appConfig, AppResponse $appResponse)
    {
        if ($this->node->getController()) {
            $controllerClassName = "Controller\\{$this->getNode()->getController()}";
            if ($controllerClassName) {
                $this->controller = new $controllerClassName($appResponse, $appConfig);
            }
        }
    }

    /**
     * @throws AppException
     */
    public function showPage()
    {
        if ($this->node->isPage()) {
            $page = self::$viewsPath . $this->node->getPage();
            if (file_exists($page)) {
                require_once $page;
            } else {
                throw new AppException("view $page not found");
            }
        }
    }

    /**
     * @throws AppException
     */
    public function callHandler()
    {
        if (!$this->node->isPage()) {
            $methodName = $this->node->getMethod() ?: strtolower($_SERVER["REQUEST_METHOD"]) ?? "get";
            $this->controller->$methodName();
        }
    }

    /**
     * @param string $path
     */
    public static function setViewsPath(string $path)
    {
        self::$viewsPath = $path;
    }

    /**
     * @return AppNode
     */
    public function getNode(): AppNode
    {
        return $this->node;
    }

    /**
     * @param AppNode $node
     */
    public function setNode(AppNode $node)
    {
        $this->node = $node;
    }

    /**
     * @return AppController
     */
    public function getController(): AppController
    {
        return $this->controller;
    }

}