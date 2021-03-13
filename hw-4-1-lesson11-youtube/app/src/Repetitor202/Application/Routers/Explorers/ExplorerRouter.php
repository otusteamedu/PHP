<?php


namespace Repetitor202\Application\Routers\Explorers;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\Explorers\YouTube\YouTubeRouter;
use Repetitor202\Application\Routers\IRouter;
use Repetitor202\Application\Routers\Router;

abstract class ExplorerRouter implements IRouter
{
    private const TYPE_YOUTUBE = 'youtube';

    public static function run(int $argvNumber = 1): void
    {
        $argv = Router::getArgv($argvNumber);

        switch ($argv) {
            case self::TYPE_YOUTUBE:
                YouTubeRouter::run($argvNumber+1);
                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }
}