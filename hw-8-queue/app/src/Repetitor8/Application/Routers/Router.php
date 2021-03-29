<?php


namespace Repetitor8\Application\Routers;


use Repetitor8\Application\Routers\Queue\QueueRouter;

abstract class Router implements IRouter
{
    private const TYPE_QUEUE = 'queue';

    public static function run(int $argvNumber = 1): void
    {
        $argv = self::getArgv();

        switch ($argv) {
            case self::TYPE_QUEUE:
                QueueRouter::run($argvNumber+1);
                break;
            default:
                throw (new \Exception('Undefined argv!'));
        }
    }

    public static function getArgv(int $argvNumber = 1): ?string
    {
        if (php_sapi_name() === 'fpm-fcgi') {
            $params = explode('?', $_ENV['REQUEST_URI']);
            $pathParams = $params[0];
            $pathParamsArr = explode('/', $pathParams);

            return $pathParamsArr[$argvNumber];
        } elseif (php_sapi_name() === 'cli') {
            return $_SERVER['argv'][$argvNumber] ?? null;
        } else {
            throw (new \Exception('Sapi_name must be fpm-fcgi or cli!'));
        }

    }
}