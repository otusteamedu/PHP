<?php

declare(strict_types=1);

namespace App;

use App\Command\CommandInterface;
use App\Config\Configuration;
use App\Console\Console;
use App\DIContainer\Container;
use App\DIContainer\ContainerInterface;
use Exception;
use UnexpectedValueException;

class App
{
    private const PATH_TO_CONFIG_INI_FILE = '/Config/config.ini';

    private ContainerInterface $container;
    private Configuration      $config;

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->container = new Container();
        $this->config = $this->getConfig();

        $this->registerProviders($this->config->getParam('providers'));
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
        try {
            $commandName = Console::getFirstArgument();

            $this->getCommand($commandName)->execute();
        } catch (Exception $e) {
            Console::error('Error: ' . $e->getMessage());
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
}
