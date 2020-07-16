<?php

namespace App\Routing;

use App\Http\Request\Request;
use App\Http\Response\Response;
use App\Routing\Exceptions\RouteException;

class Router
{
    private $arguments = [];
    private $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @throws RouteException
     */
    public function run(Request $request): array {
        $url = $request->getUrl();
        $isRouteFound = false;
        foreach ($this->config as $pattern => $routeInfo) {
            if (stristr($url, $pattern)) {
                $isRouteFound = true;
                break;
            }
        }
        $param = str_replace($pattern . '/', '', $url);
        $this->arguments[] = $param;

        if (!$isRouteFound) {
            throw new RouteException('Not Found', Response::HTTP_NOT_FOUND);
        }
        $this->checkRequestMethod($routeInfo, $request->getMethod());

        $routeInfo = explode('@', $routeInfo['action']);
        $routeInfo[] = [$param];

        return $routeInfo;
    }

    /**
     * @param array $routeInfo
     * @param $requestMethod
     * @throws RouteException
     */
    private function checkRequestMethod(array $routeInfo, $requestMethod): void {
        $method = $this->getMethod($routeInfo);
        if ($method !== $requestMethod) {
            throw new RouteException('Method Not Allowed', Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    /**
     * @param array $routeInfo
     * @return string
     */
    private function getMethod(array $routeInfo): string {
        return $routeInfo['method'][0];
    }
}