<?php

namespace App;

use Dotenv\Dotenv;
use RuntimeException;
use Throwable;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorHandler;

final class App
{

    public function __construct()
    {
        self::setErrorHandler();
        self::loadDotEnv();
    }

    public function run(): void
    {
        $opt = getopt('s::', ['server::']);

        if (isset($opt['s']) || isset($opt['server'])) {
            self::runServer();
            return;
        }

        $responce = self::runClient();
        echo $responce . PHP_EOL;
    }

    private static function runServer(): void
    {
        try {
            $socket = (new Socket(AF_UNIX, SOCK_DGRAM))->bind(Config::get('SERVER_SOCKET'));
            (new Server($socket))->run();
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        } finally {
            unset($socket);
        }
    }

    /**
     * @return string
     */
    private static function runClient(): string
    {
        global $argv;

        if (!file_exists(Config::get('SERVER_SOCKET'))) {
            return 'Error: server is not running';
        }

        try {
            $message = $argv[1] ?? Config::get('client_default_message', 'Empty message');
            $socket = (new Socket(AF_UNIX, SOCK_DGRAM))->bind(Config::get('CLIENT_SOCKET'));
            $responce = (new Client($socket))->send($message, Config::get('SERVER_SOCKET'));
            return 'Responce: ' . $responce;
        } catch (Throwable $e) {
            return 'Error: ' . $e->getMessage();
        } finally {
            unset($socket);
        }
    }

    private static function loadDotEnv(): void
    {
        Dotenv::createImmutable(__DIR__ . '/..')->load();
    }

    private static function setErrorHandler(): void
    {
        (new ErrorHandler)
            ->pushHandler(new PlainTextHandler)
            ->register();
    }
}
