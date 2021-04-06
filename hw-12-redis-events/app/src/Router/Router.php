<?php

namespace App\Router;

use App\Log\Log;
use Monolog\Logger;

class Router
{
    public static function dispatch (string $payload): string
    {
        Log::getInstance()->addRecord('query payload: ' . $payload, Logger::INFO);

        $request = json_decode($payload, true);
        $command = $request['cmd'] ?? '';
        $params  = $request['params'] ?? [];

        $fullCommandName = self::getFullCommandName($command);

        if (empty($command) || !class_exists($fullCommandName)) {
            $resultMsg = 'Bad "cmd" param ' . $command;

            Log::getInstance()->addRecord($resultMsg, Logger::ERROR);

            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => $resultMsg,
                ]
            );
        }
        else {
            return (new $fullCommandName())->execute($params);
        }
    }

    private static function getFullCommandName(string $command): string
    {
        $className = ucfirst($command) . 'Command';

        return '\App\Commands\\' . $className;
    }
}