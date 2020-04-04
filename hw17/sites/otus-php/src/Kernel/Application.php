<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Exceptions\ExistClassException;
use App\Exceptions\KernelException;

abstract class Application
{
    protected static $services = [];

    /**
     * @param string $service
     * @return object
     * @throws KernelException
     */
    public static function getInstance($service = 'app'): object
    {
        if (!isset(self::$services[$service])) {
            throw new KernelException("Service {$service} not found");
        }

        return self::$services[$service];
    }

    public function isDev(): bool
    {
        return self::$services['config']->getEnvironment() == 'dev' ?: false ;
    }
}
