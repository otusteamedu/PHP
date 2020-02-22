<?php

declare(ticks=1);

namespace App\Commands;

use App\Services\Message;
use App\Services\Socket;

class Server implements Command
{
    /** @var string */
    private $pidFile;

    /** @var bool */
    private $needStopServer = false;

    /** @var resource */
    private $stdin;

    /** @var resource */
    private $stdout;

    /** @var resource */
    private $stderr;

    public function __construct()
    {
        $this->pidFile = getenv(self::ENV_PID_FILE) ?: '/tmp/server.pid';
    }

    public function process(): void
    {
        if ($this->isServerRunning()) {
            throw new \RuntimeException('Сервер уже запущен');
        }

        $this->detached();

        Message::log('Запуск сервера');

        $socket = new Socket(getenv(self::ENV_SOCKET_SERVER));
        $socket->create();

        while (!$this->needStopServer()) {
            $socket->block();

            Message::log('Готов к получению данных...');

            $bucket = $socket->receive();

            Message::log("Получено {$bucket->getData()} от {$bucket->getFrom()}");

            $socket->unblock();

            $socket->send('OK', $bucket->getFrom());

            Message::log('Запрос выполнен');
        }

        Message::log('Сервер остановлен');

        if (file_exists($this->pidFile)) {
            unlink($this->pidFile);
        }

        $socket->close();
    }

    /**
     * Отвязываем скрипт от консоли.
     */
    private function detached(): void
    {
        if (pcntl_fork()) {
            exit();
        }

        posix_setsid();

        $dir = dirname(dirname(__DIR__)) . '/' . getenv(self::ENV_LOG_DIR);
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);

        $this->stdin = fopen('/dev/null', 'r');
        $this->stdout = fopen($dir . '/server.log', 'ab');
        $this->stderr = fopen($dir . '/server_error.log', 'ab');

        pcntl_signal(SIGTERM, [$this, 'signalHandler']);

        file_put_contents($this->pidFile, getmypid());
    }

    private function needStopServer(): bool
    {
        return $this->needStopServer === true;
    }

    private function signalHandler(int $signo): void
    {
        switch ($signo) {
            case SIGTERM:
            case SIGHUP:
            case SIGINT:
                $this->needStopServer = true;
                break;
        }
    }

    private function isServerRunning(): bool
    {
        if (is_file($this->pidFile)) {
            $pid = file_get_contents($this->pidFile);
            if (posix_kill($pid, SIG_BLOCK)) {
                return true;
            }
            unlink($this->pidFile);
        }

        return false;
    }
}
