<?php


namespace Repetitor202\Application\Routers;


use Repetitor202\Application\AppException;
use Repetitor202\Application\Routers\Events\EventsRouter;

abstract class Router implements IRouter
{
    private const TYPE_EVENTS = 'events';

    public static function run(int $argvNumber = 1): void
    {
        $argv = self::getArgv();

        switch ($argv) {
            case self::TYPE_EVENTS:
                EventsRouter::run($argvNumber+1);
                break;
            default:
                AppException::undefinedArgv($argv);
        }
    }

    public static function getArgv(int $argvNumber = 1): ?string
    {
        if (php_sapi_name() === 'fpm-fcgi') {
            $params = explode('?', $_ENV['REQUEST_URI']);
            $pathParams = $params[0];
            $pathParamsArr = explode('/', $pathParams);

            return $pathParamsArr[$argvNumber];
        } else {
            throw (new \Exception('Sapi_name is not fpm-fcgi!'));
        }
    }
}