<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Noodlehaus\Config;
use Nlazarev\Hw2_1\Model\Sockets\SocketClient;

final class AppClient
{
    private static string $conf_path = "../config/client.json";
    private static Config $conf;
    private static SocketClient $socket;

    public static function run()
    {
        static::$socket = new SocketClient();
        static::$conf = new Config(static::$conf_path);

        if (!static::$socket->isCreated()) {
            exit;
        }

        static::setParams();

        if (!static::$socket->connect((string) static::$conf->get('client.unix.socket_address'))) {
            exit;
        }

        static::goCliMsg();
    }

    private static function setParams()
    {
        static::$socket->setSendFlags((int) static::$conf->get('client.unix.cli.send.flags'))
            ->setReadBuf((int) static::$conf->get('client.unix.cli.read.buf'))
            ->setReadType((int) static::$conf->get('client.unix.cli.read.type'));
    }

    private static function goCliMsg()
    {
        echo "Connected to " . (string) static::$conf->get('client.unix.socket_address') . " - Done \n";
        echo "Type a message for send to the server [Enter] \n";
        echo "for exit, type '" . (string) static::$conf->get('client.unix.cli.exit_string') . "' \n";

        $stdin = fopen("php://stdin", "r");

        $connected = true;

        while ($connected) {

            if (!is_null($answ = static::$socket->readMsg())) {
                echo $answ . PHP_EOL;
            }

            echo "Message: ";

            $msg = fgets($stdin);

            echo PHP_EOL;

            if ($msg == (string) static::$conf->get('client.unix.cli.exit_string') . PHP_EOL) {
                $connected = false;
                fclose($stdin);
                static::$socket->close();
                continue;
            }

            static::$socket->sendMsg($msg);
        }
    }
}
