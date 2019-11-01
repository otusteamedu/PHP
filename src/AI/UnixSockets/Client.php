<?php
namespace AI\backend_php_hw4\UnixSockets;

use AI\backend_php_hw4\UnixSockets\Logger\Logger;
use AI\backend_php_hw4\UnixSockets\Settings\Settings;

class Client
{
    private $socket;
    private $log;
    public $errorLog;
    private $settings;

    public function __construct($settingsFilename)
    {
        ob_implicit_flush();
        $this->settings = new Settings($settingsFilename);
        $this->log = new Logger($this->settings->getParam('log_file'));
        $this->errorLog = new Logger($this->settings->getParam('error_log_file'));
    }

    public function __destruct()
    {
        $this->log->add("Выход.");
        socket_close($this->socket);
    }

    public function connect()
    {
        $this->log->add("Подключение к серверу.");

        if (($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new \Exception("Не удалось создать сокет: ".socket_strerror(socket_last_error()));
        }

        $this->tryToConnect();
    }

    public function run()
    {
        do {
            $this->getMessage();
            $line = trim(fgets(STDIN));
            $this->sendMessage($line);
        } while ($line != 'exit' && $line != 'shutdown');
    }

    private function tryToConnect()
    {
        echo "Подключение..";
        $attempt = 1;

        do {
            if ($attempt > $this->settings->getParam('max_connection_attempts')) {
                echo PHP_EOL;
                throw new \Exception("Не удалось соедениться с сервером за "
                    .$this->settings->getParam('max_connection_attempts')." попыток: "
                    .socket_strerror(socket_last_error()));
            }

            if ($attempt > 1) {
                sleep($this->settings->getParam('attempts_timeout'));
            }

            $this->log->add("Попытка №".($attempt++));
            echo ".";
        } while (@socket_connect($this->socket, $this->settings->getParam('socket')) === false);

        echo PHP_EOL;
        $this->log->add("Соединение установлено.");
    }

    private function getMessage()
    {
        if (($msg = @socket_read($this->socket, 1024)) === false) {
            throw new \Exception("Не удалось выполнить чтение из сокета: "
                .socket_strerror(socket_last_error($this->socket)));
        }

        echo date('Y-m-d H:i:s').' > '.$msg.PHP_EOL.'# ';
        $this->log->add("> $msg");
    }

    private function sendMessage($msg)
    {
        $msg2send = $msg.PHP_EOL;
        echo date('Y-m-d H:i:s').' < '.$msg2send;

        if (@socket_write($this->socket, $msg2send, strlen($msg2send)) === false) {
            throw new \Exception("Не удалось произвести запись в сокет: "
                .socket_strerror(socket_last_error($this->socket)));
        }

        $this->log->add("< $msg");
    }
}