<?php

namespace HW6_2;

use Monolog\Logger;
use RuntimeException;

// todo split to socket, server & client
class SocketGame
{
    public const DEFAULT_ADDRESS = '/tmp/game.sock';
    public const DEFAULT_PORT = 7777;
    public const SERVER_MODE = 'server';
    public const CLIENT_MODE = 'client';
    public const GAME_SERVER_BANNER = 'Random Game server v1';
    private $sock;
    private $address;
    private $port;
    private $client;
    private $logger;
    private $isStopped;

    /**
     * SocketAdapter constructor.
     * @param string $address
     * @param int $port
     */
    public function __construct(
        string $address = self::DEFAULT_ADDRESS,
        int $port = self::DEFAULT_PORT
    ) {
        $this->isStopped = false;
        $this->address = $address;
        $this->port = $port;
        $this->logger = new Logger('socket_game');
        $this->createSocket();
    }

    private function createSocket(): void
    {
        $this->logger->debug(\sprintf('Create socket'));
        $this->sock = socket_create(AF_UNIX, SOCK_STREAM, SOL_SOCKET);
        // or $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->sock === false) {
            throw new RuntimeException(\sprintf(
                "Не удалось выполнить socket_create(): причина: %s \n", $this->getLastError()
            ));
        }
    }

    /**
     * @return string
     */
    private function getLastError(): string
    {
        return socket_strerror(socket_last_error());
    }

    public function runServer(): void
    {
        $this->setupServer($this->address, $this->port);
        try {
            do {
                try {
                    $number = \random_int(1, 10);
                    $this->acceptClient();
                    $this->writeToClient(self::GAME_SERVER_BANNER . '.' . $number . "\n");
                    $buf = $this->readFromClient();
                    $clientNumber = (int)$buf;
                    $eps = \abs($clientNumber - $number);
                    if ($eps === 0) {
                        $answer = "You're winning\n";
                    } elseif ($eps < 4) {
                        $answer = "You're not so bad, but it's no what i need.\n";
                    } else {
                        $answer = "You're loss. See you later :)\n";
                    }
                    $this->writeToClient($answer);
                } catch (RuntimeException $e) {
                    $this->logger->err($e->getMessage(), ['exception' => $e]);
                    echo $e->getMessage();
                } catch (\Exception $e) {
                    $this->logger->err($e->getMessage(), ['exception' => $e]);
                    echo $e->getMessage();
                } finally {
                    $this->closeClient();
                }
            } while (!$this->isStopped);
        } catch (RuntimeException $e) {
            $this->logger->err($e->getMessage(), ['exception' => $e]);
            echo $e->getMessage();
        } finally {
            $this->close();
        }
    }

    /**
     * @param string $address
     * @param int $port
     */
    private function setupServer(string $address, int $port): void
    {
        $this->logger->debug(\sprintf('Run server %s:%d', $address, $port));
        $this->bind($address, $port);
        $this->listen();
    }

    /**
     * @param string $address
     * @param int $port
     */
    private function bind(string $address, int $port): void
    {
        $this->logger->debug(\sprintf('Bind socket %s:%d', $address, $port));
        if (socket_bind($this->sock, $address, $port) === false) {
            throw new RuntimeException(\sprintf(
                "Не удалось выполнить socket_bind(): причина: %s \n", $this->getLastError()
            ));
        }
    }

    private function listen(): void
    {
        $this->logger->debug(\sprintf('Listen...'));
        if (socket_listen($this->sock, 5) === false) {
            throw new RuntimeException(\sprintf(
                "Не удалось выполнить socket_listen(): причина: %s \n", $this->getLastError()
            ));
        }
    }

    /**
     * @return void
     */
    private function acceptClient(): void
    {
        $this->logger->debug(\sprintf('Wait for client...'));
        $this->client = socket_accept($this->sock);
        if ($this->client === false) {
            throw new RuntimeException(\sprintf(
                "Не удалось выполнить socket_accept(): причина: %s \n", $this->getLastError()
            ));
        }
        $this->logger->debug(\sprintf('Client connected.'));
    }

    /**
     * @param string $msg
     */
    private function writeToClient(string $msg): void
    {
        $this->logger->debug(\sprintf('Write to client: %s', $msg));
        socket_write($this->client, $msg, strlen($msg));
    }

    /**
     * @return string
     */
    private function readFromClient(): string
    {
        $buf = $this->read($this->client);
        $this->logger->debug(\sprintf('Read from client: %s', $buf));
        return $buf;
    }

    /**
     * @param $socket
     * @return string
     */
    private function read($socket): string
    {
        do {
            if (false === ($buf = socket_read($socket, 2048, PHP_NORMAL_READ))) {
                throw new RuntimeException(\sprintf(
                    "Не удалось выполнить socket_read(): причина: %s \n",
                    $this->getLastError()
                ));
            }
            if (!$buf = trim($buf)) {
                continue;
            }
            break;
        } while (true);
        return $buf;
    }

    private function closeClient(): void
    {
        if ($this->client !== false) {
            $this->logger->debug(\sprintf('Close client.'));
            socket_close($this->client);
        }
    }

    private function close(): void
    {
        if ($this->sock !== false) {
            $this->logger->debug(\sprintf('Close socket.'));
            socket_close($this->sock);
        }
    }

    public function stopServer(): void
    {
        $this->logger->debug(\sprintf('Server will be stopped...'));
        $this->isStopped = true;
    }

    public function game($number): void
    {
        $this->connectToServer();
        $this->readFromServer();
        $this->writeToServer($number . "\n");
        $this->readFromServer();
        $this->close();
    }

    private function connectToServer(): void
    {
        if (socket_connect($this->sock, $this->address, $this->port) === false) {
            throw new RuntimeException(\sprintf(
                "Не удалось выполнить socket_connect(): причина: %s \n",
                $this->getLastError()
            ));
        }
    }

    /**
     * @return string
     */
    private function readFromServer(): string
    {
        $buf = $this->read($this->sock);
        $this->logger->debug(\sprintf('Read from server: %s', $buf));
        return $buf;
    }

    /**
     * @param string $buffer
     */
    private function writeToServer(string $buffer): void
    {
        $this->logger->debug(\sprintf('Write to server: %s', $buffer));
        socket_write($this->sock, $buffer, strlen($buffer));
    }
}