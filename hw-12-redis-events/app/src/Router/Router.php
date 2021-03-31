<?php

namespace App\Router;

use App\Log\Log;
use Monolog\Logger;

class Router
{
    public static function dispatch(string $payload)
    {
        Log::getInstance()->addRecord('query payload: ' . $payload, Logger::INFO);

        $request = json_decode($payload, true);
        $command = $request['cmd'] ?? '';

        $fullCommandName = self::getFullCommandName($command);

        if (empty($command) || !class_exists($fullCommandName)) {
            $resultMsg = 'Bad "cmd" param ' . $command;

            Log::getInstance()->addRecord($resultMsg, Logger::ERROR);

            return json_encode(['error' => $resultMsg]);
        }
        else {
            return (new $fullCommandName())->execute();
        }
    }

    private static function getFullCommandName(string $command): string
    {
        $className = ucfirst($command) . 'Command';

        return '\App\Commands\\' . $className;
    }
}