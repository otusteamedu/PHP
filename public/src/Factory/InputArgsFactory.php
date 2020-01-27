<?php

declare(strict_types=1);

namespace Socket\Ruvik\Factory;

use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\Exception\RuntimeException;

class InputArgsFactory implements InputArgsFactoryInterface
{
    public function create(array $args): InputArgs
    {
        $argsParse = getopt(implode('', self::SHORT_OPTIONS), self::LONG_OPTIONS);
        $route = $argsParse[self::LONG_OPTION_ROUTE] ?? $argsParse[self::SHORT_OPTION_ROUTE] ?? null;
        $message = $argsParse[self::LONG_OPTION_MESSAGE] ?? $argsParse[self::SHORT_OPTION_MESSAGE] ?? null;
        if (null === $route || null === $message) {
            throw new RuntimeException('Invalid required params');
        }

        return new InputArgs((string) $route, (string) $message);
    }
}
