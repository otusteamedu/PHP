<?php


namespace Repetitor202\Application\Routers\Events\YouTube;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\IRouter;
use Repetitor202\Application\Routers\Router;
use Repetitor202\Domain\Services\Explorers\YouTube\VideoService;

class VideoRouter implements IRouter
{
    private const TYPE_REPORT = 'report';
//    private const TYPE_SAVE = 'save';

    public static function run(int $argvNumber = 1): void
    {
        $argv = Router::getArgv($argvNumber);
        $service = new VideoService();

        switch ($argv) {
            case self::TYPE_REPORT:
                $service->report();
                break;
//            case self::TYPE_SAVE:
//                $videoIDs = Router::getArgv($argvNumber+1)  ?? AppException::argvIsRequired();
//                $service->initSaveVideos($videoIDs);
//                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }
}