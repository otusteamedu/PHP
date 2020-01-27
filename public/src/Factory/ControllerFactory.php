<?php

declare(strict_types=1);

namespace Socket\Ruvik\Factory;

use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\Exception\RuntimeException;

class ControllerFactory
{
    /** @var array */
    private static array $routeIni;

    public function create(InputArgs $inputArgs): Route
    {
        if (! isset($this->getRouteIni()[$inputArgs->getRoute()])) {
            throw new RuntimeException('Route undefined');
        }

        return new ($inputArgs->getRoute());
    }

    private function getRouteIni()
    {
        if (null === self::$routeIni) {
            self::$routeIni = parse_ini_file(__CONFIG_DIR__ . '/route.ini', true);
        }

        return self::$routeIni;
    }
}
