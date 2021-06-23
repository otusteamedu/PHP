<?php
namespace Src;

/**
 * Initializes routes
 *
 * @author <Denis Morozov>
 */
class App
{
    private ?array $argv;

    public function __construct(?array $argv)
    {
        $this->argv = $argv;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $router = new Route($this->argv);
        $router->init();
    }
}