<?php
namespace Otus;

use Symfony\Component\Yaml\Yaml;

final class App
{
    private $config;
    private $router;

    public function __construct()
    {
        $this->config = Yaml::parseFile(dirname(__DIR__) . '/config.yml');
        $this->router = new \AltoRouter();
        $this->mapRoutes();
    }

    public function run(): void
    {
        // match current request url
        $match = $this->router->match();

        // call closure or throw 404 status
        if (is_array($match) && is_callable($match['target'])) {
            call_user_func_array($match['target'], $match['params']);
        } else {
            // no route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }

    private function mapRoutes(): void
    {
        // map homepage
        $this->router->map('GET', '/', function() {
            print 'Homework #16';
        });

    }
}