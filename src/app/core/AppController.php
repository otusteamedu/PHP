<?php

namespace Core;

abstract class AppController
{
    public const CONTROLLERS_NAMESPACE = "Controllers\\";

    /** @var AppResponse $response */
    protected $response;

    /** @var AppConfig $appConfig */
    protected $appConfig;

    public function __construct()
    {
        $this->response = new AppResponse();
        $this->appConfig = new AppConfig();
    }

    /**
     * @param string $controllerName
     * @return AppController
     * @throws AppException
     */
    public static function getInstance(string $controllerName): AppController
    {
        $controllerClassName = self::CONTROLLERS_NAMESPACE . $controllerName;
        if (class_exists($controllerClassName)) {
            $controller = new $controllerClassName();
            return $controller;
        }
        throw new AppException("controller not exists", 500);
    }

    /**
     * @param AppResponse $response
     */
    public function setResponse(AppResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @param AppConfig $appConfig
     */
    public function setAppConfig(AppConfig $appConfig): void
    {
        $this->appConfig = $appConfig;
    }
}