<?php
namespace AI\backend_php_hw4\UnixSockets;

use AI\backend_php_hw4\UnixSockets\Logger\Logger;
use AI\backend_php_hw4\UnixSockets\Settings\Settings;

class Server
{
    private $socket;
    private $connection;
    private $log;
    public $errorLog;
    private $settings;
    private $doShutdown;

    public function __construct($settingsFilename)
    {
        ob_implicit_flush();
        $this->settings = new Settings($settingsFilename);
        $this->log = new Logger($this->settings->getParam('log_file'));
        $this->errorLog = new Logger($this->settings->getParam('error_log_file'));
        $this->doShutdown = false;
    }

    public function __destruct()
    {
        $this->log->add("Остановка сервера.");

        socket_close($this->socket);
        if (file_exists($this->settings->getParam('socket'))) {
            unlink($this->settings->getParam('socket'));
        }
    }

    public function run()
    {
        try {
            $this->waitAndServeClient();
        } catch (\Exception $e) {
            $this->errorLog->add($e->getMessage());
        }
    }

    public function raise()
    {
        $this->log->add("Запуск сервера.");

        if (($this->socket = @socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new \Exception("Не удалось создать сокет: ".socket_strerror(socket_last_error()));
        }

        if (@socket_set_nonblock($this->socket) === false) {
            throw new \Exception("Не удалось установить режим для сокета socket_set_nonblock: "
                .socket_strerror(socket_last_error()));
        }

        if (@socket_bind($this->socket, $this->settings->getParam('socket')) === false) {
            throw new \Exception("Не удалось привязать сокет: ".socket_strerror(socket_last_error()));
        }

        if (@socket_listen($this->socket, 5) === false) {
            throw new \Exception("Не удалось выполнить socket_listen: ".socket_strerror(socket_last_error()));
        }

        $this->log->add("Сервер запущен.");
    }

    private function waitAndServeClient()
    {
        do {
            $this->connection = socket_accept($this->socket);

            if ($this->connection === false) {
                usleep($this->settings->getParam('socket_accept_timeout'));
            }
            elseif ($this->connection > 0) {
                $this->log->add("Клиент подключился.");
                $this->handleClient();
            }
            else {
                throw new \Exception("Не удалось не удалость принять соединение на сокете socket_accept: "
                    .socket_strerror(socket_last_error($this->socket)));
            }
        } while (!$this->doShutdown);
    }

    private function handleClient()
    {
        $doExit = false;
        $helpMessage = PHP_EOL.file_get_contents(__DIR__.'/Settings/server_help.txt');
        $this->sendMessage($helpMessage, "Начало новой сессии.");

        do {
            $receivedMsg = $this->receiveMessage();

            if ($receivedMsg == 'help') {
                $this->sendMessage($helpMessage, "Выполнена команда 'help'");
            }
            elseif ($receivedMsg == 'exit') {
                $doExit = true;
                socket_close($this->connection);
                $this->log->add("Выполняется команда 'exit'");
            }
            elseif ($receivedMsg == 'shutdown') {
                $this->doShutdown = true;
                socket_close($this->connection);
                $this->log->add("Выполняется команда 'shutdown'");
            }
            else {
                $feedback = "Вы сказали '$receivedMsg'";
                $this->sendMessage($feedback, "Выполнена команда 'echo': $feedback");
            }
        } while (!$doExit && !$this->doShutdown);
    }

    private function sendMessage($msg, $string2log) {
        if (@socket_write($this->connection, $msg, strlen($msg)) === false) {
            throw new \Exception("Не удалось произвести запись в сокет: "
                .socket_strerror(socket_last_error($this->connection)));
        }

        $this->log->add($string2log);
    }

    private function receiveMessage() {
        if (($msg = @socket_read($this->connection, 1024)) === false) {
            throw new \Exception("Не удалось выполнить чтение из сокета: "
                .socket_strerror(socket_last_error($this->connection)));
        }

        $msg = trim($msg);
        $this->log->add("Получено сообщение: ".$msg);

        return $msg;
    }
}