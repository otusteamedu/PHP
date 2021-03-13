<?php


namespace Repetitor202\Application\Routers\Explorers\YouTube;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\IRouter;
use Repetitor202\Application\Routers\Router;

abstract class YouTubeRouter implements IRouter
{
    private const TYPE_VIDEO = 'video';
    private const TYPE_CHANNEL = 'channel';

    public static function run(int $argvNumber = 1): void
    {
        $argv = Router::getArgv($argvNumber);

        switch ($argv) {
            case self::TYPE_VIDEO:
                VideoRouter::run($argvNumber+1);
                break;
            case self::TYPE_CHANNEL:
                ChannelRouter::run($argvNumber+1);
                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }
}