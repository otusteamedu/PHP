<?php

namespace HW4;

/**
 * Class Client
 * @package HW4
 */
class Client
{
    private $address;
    private $port;
    private $socket;
    private $socketService;

    public function __construct($address, $port)
    {
        $this->address = $address;
        $this->port = $port;
        $this->socketService = new SocketService($this->address, $this->port);
    }

    /**
     * Отправка запроса на сервер
     */
    public function sendRequest(): void
    {
        $this->socket = $this->socketService->create();
        $this->socketService->connect();
        $request = $this->getRequestFromKeyboard();
        $this->socketService->write($this->socket, $request);
    }

    /**
     * Получение ответа от сервера
     *
     * @return string
     */
    public function getResponse()
    {
        $data = trim($this->socketService->read());
        $this->socketService->close();
        return $data;
    }

    /**
     * Метод получает ввод с клавиатуры
     *
     * @return string
     */
    private function getRequestFromKeyboard()
    {
        echo "Введите число, которое нужно преобразовать в строку: ";

        $input = '';

        while($input == '') {
            $stdin = fopen('php://stdin', 'r');
            $input = trim(fgets($stdin, 255));
            fclose($stdin);
        }

        echo PHP_EOL;
        return $input;
    }
}