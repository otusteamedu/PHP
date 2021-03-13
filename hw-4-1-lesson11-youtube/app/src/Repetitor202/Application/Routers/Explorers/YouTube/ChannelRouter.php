<?php


namespace Repetitor202\Application\Routers\Explorers\YouTube;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\IRouter;
use Repetitor202\Application\Routers\Router;
use Repetitor202\Domain\Services\Explorers\YouTube\ChannelService;

class ChannelRouter implements IRouter
{
    private const TYPE_REPORT = 'report';
    private const TYPE_SAVE = 'save';
    private const TYPE_TOP = 'top';
    private const TYPE_UPDATE = 'update-list';

    public static function run(int $argvNumber = 1): void
    {
        $argv = Router::getArgv($argvNumber);
        $service = new ChannelService();

        switch ($argv) {
            case self::TYPE_REPORT:
                $service->printChannels();
                break;
            case self::TYPE_SAVE:
                $channelId = Router::getArgv($argvNumber+1)  ?? AppException::argvIsRequired();
                $service->saveChannel($channelId);
                break;
            case self::TYPE_TOP:
                $topNumber = Router::getArgv($argvNumber+1)  ?? AppException::argvIsRequired();
                $service->top($topNumber);
                break;
            case self::TYPE_UPDATE:
                $service->updateList();
                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }
}