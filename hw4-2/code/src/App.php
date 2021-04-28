<?php
declare(strict_types=1);

namespace App;

use App\Socket\ClientSocket;
use App\Socket\ServerSocket;
use ErrorException;

/**
 * Class App
 */
final class App
{
    private const SOCKET_TYPE_SERVER = 'server';
    private const SOCKET_TYPE_CLIENT = 'client';

    private const SOCKET_TYPES = [
        self::SOCKET_TYPE_SERVER,
        self::SOCKET_TYPE_CLIENT,
    ];

    /**
     * @var string
     */
    private string $socketPath;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->setErrorHandler();

        $this->socketPath = parse_ini_file('config.ini')['socket_path'];
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $socketType = $_SERVER['argv'][1] ?? null;

        if (empty($socketType)) {
            throw new \RuntimeException(
                'Socket type is required'
            );
        }

        if (!in_array($socketType, self::SOCKET_TYPES)) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid socket type "%s", must be one of "%s".',
                    $socketType,
                    implode('", "', self::SOCKET_TYPES)
                )
            );
        }

        if ($socketType === self::SOCKET_TYPE_SERVER) {
            $this->processServer();
        } else {
            $this->processClient();
        }
    }

    /**
     * @return void
     */
    private function processClient(): void
    {
        $socket = new ClientSocket();
        $socket->connect($this->socketPath);

        while (true) {
            $this->printLine('Enter message:');

            $message = $this->readLine();

            $socket->write($message);

            if (in_array($message, ['q', 'quit'])) {
                break;
            }

            $this->printLine("Waiting for server's response...");

            $message = $socket->readAll();

            $this->printLine("Server says: {$message}");
        }

        $socket->close();
    }

    /**
     * @return void
     */
    private function processServer(): void
    {
        $socket = new ServerSocket();
        $socket->bind($this->socketPath);
        $socket->listen();

        while (true) {
            $this->printLine("Waiting for client's message...");

            $message = $socket->readAll();

            if (in_array($message, ['q', 'quit'])) {
                break;
            }

            $this->printLine("Client says: {$message}");
            $this->printLine('Enter reply:');

            $message = $this->readLine();

            $socket->write($message);
        }

        $socket->close();
    }

    /**
     * @param string $message
     *
     * @return void
     */
    private function printLine(string $message): void
    {
        echo $message, PHP_EOL;
    }

    /**
     * @return string
     */
    private function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }

    /**
     * @return void
     */
    private function setErrorHandler(): void
    {
        set_error_handler(
            function (int $level, string $message, string $file, int $line) {
                throw new ErrorException($message, 0, $level, $file, $line);
            },
            E_ALL
        );
    }
}
