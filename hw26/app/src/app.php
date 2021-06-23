<?php

declare(strict_types=1);

namespace App;

use App\Framework\Config\Configuration;
use App\Framework\Command\CommandInterface;
use App\Framework\Console\Argument\ArgumentTypes;
use App\Framework\Console\ConsoleInterface;
use App\Framework\Console\ExpectedArgument\ExpectedArgument;
use App\Framework\DIContainer\Container;
use App\Framework\DIContainer\ContainerInterface;
use App\Framework\Http\Request;
use App\Framework\Http\Response;
use App\Framework\Router\Router;
use App\Framework\Router\RoutesLoader;
use Exception;
use ReflectionException;
use UnexpectedValueException;

class App
{
    private const PATH_TO_CONFIG_INI_FILE = '/Config/config.ini';
    private const PATH_TO_ROUTES_INI_FILE = '/Config/routes.ini';

    private ContainerInterface $container;
    private Configuration      $config;
    private ConsoleInterface   $console;

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @throws ReflectionException
     */
    private function initialize(): void
    {
        $this->container = new Container();
        $this->config = $this->getConfig();

        $this->registerProviders($this->config->getParam('providers'));

        $this->console = $this->container->get(ConsoleInterface::class);
    }

    private function getConfig(): Configuration
    {
        if (!$this->container->has(Configuration::class)) {
            $config = new Configuration(__DIR__ . self::PATH_TO_CONFIG_INI_FILE);
            $this->container->set(Configuration::class, $config);
        }

        return $this->container->get(Configuration::class);
    }

    private function registerProviders(array $providers): void
    {
        foreach ($providers as $providerClassName) {
            $provider = new $providerClassName($this->config, $this->container);
            $provider->register();
        }
    }

    public function run(): void
    {
        if ($this->isCliRequest()) {
            $this->handleConsoleRequest();
        } else {
            $this->handleHttpRequest();
        }
    }

    private function handleConsoleRequest(): void
    {
        try {
            $this->console->addExpectedArgument(new ExpectedArgument('commandName', ArgumentTypes::STRING));
            $commandName = $this->console->getArgumentByName('commandName')->getValue();

            $this->container->callMethod($this->getCommand($commandName), 'run');
        } catch (Exception $e) {
            $this->console->error('Error: ' . $e->getMessage());
        }
    }

    private function handleHttpRequest(): void
    {
        try {
            $routesConfig = new Configuration(__DIR__ . self::PATH_TO_ROUTES_INI_FILE);
            $routeCollection = (new RoutesLoader($routesConfig))->load();
            $router = new Router($routeCollection);

            $route = $router->match($this->getRequest());

            $handler = $this->container->get($route->getHandler()[0]);
            $response = $this->container->callMethod($handler, $route->getHandler()[1]);

            $response->send();
        } catch (Exception $e) {
            $response = new Response(400, $e->getMessage());

            $response->send();
        }
    }

    private function getCommand(string $commandName): CommandInterface
    {
        $commands = $this->config->getParam('commands');

        if (empty($commands[$commandName])) {
            throw new UnexpectedValueException("Неизвестная команда $commandName");
        }

        return $this->container->get($commands[$commandName]);
    }

    private function isCliRequest(): bool
    {
        return (php_sapi_name() === 'cli');
    }

    private function getRequest(): Request
    {
        return new Request();
    }
}
