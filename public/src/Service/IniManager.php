<?php

declare(strict_types=1);

namespace Socket\Ruvik\Service;

use Socket\Ruvik\DTO\RouteConfig;
use Socket\Ruvik\DTO\SocketConfig;
use Socket\Ruvik\Environment;
use Socket\Ruvik\Exception\RuntimeException;

class IniManager
{
    public const SOCKET_ADDRESS = 'address';
    public const SERVER_SOCKET_ENV = 'server';
    public const CLIENT_SOCKET_ENV = 'client';


    protected static ?RouteConfig $routeConfig = null;
    protected static ?SocketConfig $socketConfig = null;

    public function getSocketConfig(): SocketConfig
    {
        if (null === self::$socketConfig) {
            $socketConfigArray = parse_ini_file(__CONFIG_DIR__ . '/config.ini', true);

            self::$socketConfig = new SocketConfig(
                $socketConfigArray[self::SERVER_SOCKET_ENV][self::SOCKET_ADDRESS],
                $socketConfigArray[self::CLIENT_SOCKET_ENV][self::SOCKET_ADDRESS]
            );

            if (empty(self::$socketConfig)) {
                throw new RuntimeException('Undefined config.ini');
            }

            return self::$socketConfig;
        }
    }

    public function getRoute(): RouteConfig
    {
        if (null === self::$routeConfig) {
            self::$routeConfig = new RouteConfig(parse_ini_file(__CONFIG_DIR__ . '/route.ini', true));
            if (false === self::$routeConfig) {
                throw new RuntimeException('Undefined route.ini');
            }
        }

        return self::$routeConfig;
    }
}
