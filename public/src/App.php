<?php

declare(strict_types=1);

namespace Socket\Ruvik;

use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\Exception\RuntimeException;
use Socket\Ruvik\Factory\InputArgsFactoryInterface;
use Socket\Ruvik\Service\Router;

class App
{
    /**
     * @var InputArgsFactoryInterface
     */
    private $inputArgsFactory;
    /**
     * @var Router
     */
    private $router;

    public function __construct(
        InputArgsFactoryInterface $inputArgsFactory,
        Router $router
    )
    {
        $this->inputArgsFactory = $inputArgsFactory;
        $this->router = $router;
    }

    public function run(array $args): void
    {
        $inputArgs = $this->inputArgsFactory->create($args);
//        Environment::initEnv($inputArgs->getEnv());
        $controller = $this->router->getController($inputArgs);
        $controller->run($inputArgs);

//        $router = new Router();
//        $controller = $router->resolveCommand($args[1]);
//        $controller->run($args[2] ?? null);
    }
}
