<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use DI\ContainerBuilder;

class QueueWorkerApp extends Application
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config) {
        Application::$services['app'] = $this;
        Application::$services['config'] = $config;
        Application::$services['db'] = Application::$services['config']->createDbClient();
        Application::$services['queueClient'] = Application::$services['config']->createQueueClient();
    }

    /**
     * @param string $workerClass
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function run(string $workerClass)
    {
        Config::setExceptionHandler();

        $container = ContainerBuilder::buildDevContainer();

        $app = $container->get(QueueWorkerApp::class);

        $worker = $container->get($workerClass);
        $worker->run();
    }
}