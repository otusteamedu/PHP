<?php

namespace App\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

final class Console extends Application
{
    public function __construct()
    {
        /** @noinspection PhpFullyQualifiedNameUsageInspection */
        if (class_exists(\PHPUnit\Runner\Version::class, false)) {
            return;
        }

        parent::__construct();

        if ('prod' === getenv('APP_ENV')) {
            $this->setCatchExceptions(false);
        }

        $this->setCommandLoader(new FactoryCommandLoader(self::list()));

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->run();
    }

    private static function list(): array
    {
        return [
            Example::getDefaultName() => fn() => new Example(),
        ];
    }
}
