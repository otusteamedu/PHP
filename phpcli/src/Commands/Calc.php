<?php


namespace App\Commands;

use App\Services\Socket\Socket;
use App\Commands\Entity\ResultInterface;
use App\Commands\Entity\ResultSimple;

class Calc implements CommandInterface
{
    private const UNIX_SOCKET_SERVER = 'calcserver.sock';
    private const UNIX_SOCKET_CLIENT = 'calcclient.sock';
    private const TYPE_SERVER = 'server';
    private const TYPE_CLIENT = 'client';
    private const SOCKET_NAME_BY_ARGUMENT = [
        self::TYPE_SERVER => self::UNIX_SOCKET_SERVER,
        self::TYPE_CLIENT => self::UNIX_SOCKET_CLIENT,
    ];

    private $shortopts = 't:e:s';
    private $longopts = [
        'type:',
        'expression:',
        "socket",
    ];
    private $reg = '/^(\d[*+-\/])+\d+$/';
    private $socket = null;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function getShortOptions(): string
    {
        return $this->shortopts;
    }

    public function getLongOptions(): array
    {
        return $this->longopts;
    }

    public function run(array $options): ResultInterface
    {
        $useSocket = !($options['s'] ?? $options['socket'] ?? true);

        if ($useSocket) {
            if (!($this->socket instanceof Socket)) {
                throw new \ErrorException('ERROR: Calc::run(): не определен сокет');
            }
            if (!isset($options['type']) && !isset($options['t'])) {
                throw new \InvalidArgumentException('ERROR: Calc::run(): Отсутствует параметр --type|-t');
            }

            $type = $options['type'] ?? $options['t'];
            $socketName = $this->getSocketName($type);

            if ($type === self::TYPE_SERVER) {
                return $this->socketServer($socketName);
            }

            if ($type === self::TYPE_CLIENT) {
                if (!isset($options['expression']) && !isset($options['e'])) {
                    throw new \InvalidArgumentException('ERROR: Calc::run(): Отсутствует параметр --expression|-e (useSocket)');
                }

                return $this->socketClient($socketName, $options);
            }

            return new ResultSimple('end: не удалось определить качество работы скрипта (client|sever)');
        }


        if (!isset($options['expression']) && !isset($options['e'])) {
            throw new \InvalidArgumentException('ERROR: Calc::run(): Отсутствует параметр --expression|-e');
        }

        return new ResultSimple($this->action($options['expression'] ?? $options['e']));
    }

    /**
     * Формируем имя сокета в зависимости от клиент или сервер
     * @param string $type - client|server
     * @return string|null
     * @throws \ErrorException
     */
    private function getSocketName(string $type): ?string
    {
        $socketName = self::SOCKET_NAME_BY_ARGUMENT[$type] ?? null;
        if ($socketName === null) {
            throw new \ErrorException('ERROR: Calc::getSocketName(): не удалось определить тип подключения (client|server)');
        }

        if ($type === self::TYPE_CLIENT) {
            $socketName = random_int(999999, 1000000000) . $socketName;
        }

        return $socketName;
    }

    /**
     * Непосредственно производим вычисления
     * @param string $expression
     * @return float
     */
    private function action(string $expression): float
    {
        if (!preg_match($this->reg, $expression)) {
            throw new \InvalidArgumentException('ERROR: Calc::action(): Аргумент не является арифметическим выражением');
        }

        return (float)eval('return ' . $expression . ';');
    }

    /**
     * Код серверной части скрипта
     * @param string $socketName
     * @return ResultSimple
     * @throws \ErrorException
     */
    private function socketServer(string $socketName): ResultSimple
    {
        $this->socket->createSocket(AF_UNIX, $socketName);

        while (true) {
            $res = $this->socket->read();
            echo $res->getMessage() . "\n";
            $this->socket->write($this->action($res->getMessage()), $res->getFrom());
        }

        $this->socket->closeSocket();

        return new ResultSimple('server stop');
    }

    /**
     * Код клиентской части скрипта
     * @param string $socketName
     * @param array $options
     * @return ResultSimple
     * @throws \ErrorException
     */
    private function socketClient(string $socketName, array $options): ResultSimple
    {
        $this->socket->createSocket(AF_UNIX, $socketName);

        $this->socket->write(
            $options['expression'] ?? $options['e'],
            $this->socket->getDirSockets() . self::UNIX_SOCKET_SERVER
        );
        $res = $this->socket->read();

        $this->socket->closeSocket();

        return new ResultSimple($res->getMessage());
    }
}