<?php

namespace Core;

use Controllers\AppController;

class App
{
    /** @var AppResponse $response */
    protected $response;

    /** @var AppConfig $appConf */
    protected $appConf;

    private $reqStr = "";

    private static $routesMap = [];
    private static $viewsPath = "";

    public function __construct(string $appConfIniPath)
    {
        $this->response = new AppResponse();
        $this->appConf = $appConf = new AppConfig($appConfIniPath);
        if (empty(self::$routesMap)) {
            $this->response->content = "no routes was found; set routes first";
            $this->response->flush(500);
        }
        $this->reqStr = $requestStr ?? $_SERVER["REQUEST_URI"] ?? "/";
    }

    /**
     * @param string|null $routesPath
     */
    public static function setRoutes(?string $routesPath)
    {
        foreach (json_decode(file_get_contents($routesPath)) as $node) {
            self::$routesMap[$node->request] = $node;
        }
    }

    /**
     * @param string $viewsPath
     */
    public static function setViewsPath(string $viewsPath): void
    {
        self::$viewsPath = $viewsPath;
    }

    public function run()
    {
        $reqNodes = explode("/", $this->reqStr);
        $mapNode = self::$routesMap[$this->reqStr];
        if ($mapNode) {
            $controllerClassName = "Controllers\\" . ($mapNode->controller ?? ucfirst($reqNodes[0]) ?? null);
            $methodName = $mapNode->method ?? $reqNodes[1] ?? "get";
            try {
                $controller = new $controllerClassName($this->response, $this->appConf);
            } catch (\Throwable $e) {
            }
            if ($viewPage = ($mapNode->page ?? null)) {
                if (file_exists(self::$viewsPath . $viewPage)) {
                    require_once self::$viewsPath . $viewPage;
                } else {
                    $this->response->flush(404);
                    return;
                }
            } else {
                if (method_exists($controller, $methodName) && ($controller instanceof AppController)) {
                    try {
                        $controller->$methodName();
                    } catch (AppException $e) {
                        $this->response->content = $e->getMessage();
                        $this->response->flush(400);
                        return;
                    }
                    $this->response->flush(200);
                } else {
                    $this->response->flush(404);
                    return;
                }
            }
        }
    }
}