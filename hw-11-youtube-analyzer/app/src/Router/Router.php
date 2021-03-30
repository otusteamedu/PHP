<?php

namespace App\Router;

use App\Log\Log;
use Monolog\Logger;

class Router
{
    public static function dispatch(string $cmd)
    {
        $fullCommandName = self::getFullCommandName($cmd);

        if (empty($cmd) || !class_exists($fullCommandName)) {
            $resultMsg = 'Bad "cmd" param ' . $cmd;

            Log::getInstance()->addRecord($resultMsg, Logger::ERROR);

            return json_encode(['error' => $resultMsg]);
        }
        else {
            return (new $fullCommandName())->execute();
        }
    }

    private static function getFullCommandName(string $cmd): string
    {
        $className = ucfirst($cmd) . 'Command';

        return '\App\Commands\\' . $className;
    }
}