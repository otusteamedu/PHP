<?php

namespace Otus\Http;

use Dotenv\Dotenv;
use Otus\Config\Config;

class App
{
    private string $basePath;

    private Router $router;

    public function __construct(string $path)
    {
        $this->basePath = $path;

        $this->loadEnvironment()
             ->loadConfiguration();

        $this->router = new Router($path);
    }

    public function run(): void
    {
        $response = $this->router->handle();
        $response->send();
    }

    private function loadEnvironment(): self
    {
        $dotenv = Dotenv::createImmutable($this->basePath);
        $dotenv->load();

        return $this;
    }

    private function loadConfiguration(): self
    {
        Config::getInstance($this->basePath.'config/app.php');

        return $this;
    }
}
