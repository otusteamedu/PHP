<?php

namespace HW4;

use NumberToWords\NumberToWords;

/**
 * Class Server
 * @package HW4
 */
class Server
{
    private $address;
    private $port;
    private $socket;
    private $socketService;
    private $numberTransformer;
    private $socketListen;

    // @TODO Временное решение
    const TEXT = [
        'message' => 'Получено "%s". Отправлено "%s".' . PHP_EOL,
        'error' => 'Пожалуйста, отправьте число.',
        'serverStoped' => 'Сервер остановлен'
    ];

    public function __construct($address, $port)
    {
        $this->address = $address;
        $this->port = $port;
        $this->socketService = new SocketService($this->address, $this->port);
        $this->numberTransformer = (new NumberToWords())->getNumberTransformer('ru');
    }

    /**
     * Создание сокета.
     * Метод создаёт сокет и начинает его слушать
     */
    public function up(): void
    {
        $this->socket = $this->socketService->create();

        $this->socketService->bind($this->socket);
        $this->socketService->listen($this->socket);

        $this->listen();
    }

    /**
     * Прослушивание сокета.
     * Если получено сообщение, то переводит обработку запроса в метод processRequest
     */
    private function listen(): void
    {
        $this->socketListen = true;
        while ($this->socketListen) {
            if ($listenedSocket = $this->socketService->accept()) {
                $request = trim($this->socketService->read($listenedSocket));

                if (!empty($request)) {
                    $this->processRequest($listenedSocket, $request);
                    $this->socketService->close($listenedSocket);
                }
            }
        }
        $this->socketService->close();
    }

    /**
     * Обработка запроса от клиента
     *
     * @param $listenedSocket
     * @param string $request
     */
    private function processRequest($listenedSocket, string $request): void
    {
        if ($request == 'stop') {
            $this->socketListen = false;
            $this->socketService->write($listenedSocket, self::TEXT['serverStoped']);
        } else {
            $response = $this->numberTransformer->toWords($request);
            if (empty($response)) {
                $response = self::TEXT['error'];
            }
            $this->socketService->write($listenedSocket, $response);
        }
    }
}