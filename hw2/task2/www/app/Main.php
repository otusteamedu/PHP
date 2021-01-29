<?php

namespace App2;

use App2\Socket\SocketApp;

/**
 * Class Main
 * @package App2
 */
class Main
{
    const ISCLI = (PHP_SAPI === 'cli');
    private string $param = '';

    /**
     * Main constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if (!self::ISCLI) {
            throw new \Exception("Это консольное приложение" . PHP_EOL);
        }

        if (count($_SERVER["argv"]) <= 1 ) {
            throw new \Exception("Нет обазятельного параметра ['server|client']" . PHP_EOL);
        }

        $this->param = $_SERVER["argv"][1];
    }

    /**
     * @throws Exception\ExceptionSocket
     * @throws \Exception
     */
    public function run()
    {
        $socket = new SocketApp();
        if ($this->param === 'server'){
            $socket->server();
        } elseif($this->param === 'client') {
            $socket->client();
        }

        throw new \Exception("Неверный обазятельный параметр ['server|client']" . PHP_EOL);
    }
}