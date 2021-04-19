<?php

namespace Otushw\ServerAPI\Router;

use Psr\Http\Message\ServerRequestInterface;

class Route
{
    const PREFIX = '/\\/{id}/';
    const PATTERN_ID = '{/[\d]+$}';

    private string $path;
    private string $method;
    private string $controller;
    private string $action;
    private string $uri;

    public function __construct(string $path, string $method, string $controller, string $action)
    {
        $this->path = $path;
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
        $this->uri = $this->getURI($path);
    }

    public function check(ServerRequestInterface $request): ?ControllerFactory
    {
        if ($request->getMethod() != $this->method) {
            return null;
        }

        $path = $request->getUri()->getPath();
        if (preg_match('~^' . $this->path . '$~', $path, $matches) === 0) {
            return null;
        }

        $id = $this->getID($path);
        return new ControllerFactory($this->controller, $this->action, $id);
    }

    private function getURI(string $path): string
    {
        if (preg_match('/\{id\}/', $path, $matches)) {
            if (!empty($matches)) {
                $path = $this->getPath($path, self::PREFIX);
            }
        }
        return $path;
    }

    private function getPath(string $path, string $pattern = self::PATTERN_ID): string
    {
        $path = preg_replace($pattern,'', $path);
        return $path;
    }

    private function getID(string $path): ?int
    {
        $id = null;
        if (preg_match(self::PATTERN_ID, $path, $matches)){
            $id = str_replace('/', '', $matches[0]);
        }
        return $id;
    }

}
