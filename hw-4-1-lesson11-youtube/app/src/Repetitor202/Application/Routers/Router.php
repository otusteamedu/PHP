<?php


namespace Repetitor202\Application\Routers;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\Explorers\ExplorerRouter;

abstract class Router implements IRouter
{
    private const TYPE_EXPLORER = 'explorer';

    public static function run(int $argvNumber = 1): void
    {
        $argv = self::getArgv();

        switch ($argv) {
            case self::TYPE_EXPLORER:
                ExplorerRouter::run($argvNumber+1);
                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }

    public static function getArgv(int $argvNumber = 1): ?string
    {
        if (php_sapi_name() === 'cli') {
            return $_SERVER['argv'][$argvNumber] ?? null;
        } else {
            AppException::needCliMode();
        }
    }
}