<?php


namespace Sockets;


use JetBrains\PhpStorm\Pure;

abstract class mainSocket
{
    protected \Sockets\socket $socket;
    protected int $domain;

    /**
     * mainSocket constructor.
     * @param string $host
     * @param string $path
     * @param int $port
     * @param string $Domain
     * @param int $maxConnections
     * @param int $buffer_length
     */
    public function __construct(
        protected string $host,
        protected string $path,
        protected int $port,
        protected string $Domain,
        protected int $maxConnections = 5,
        protected int $buffer_length = 1024,
    )
    {
        $this->initSocket();
    }

    /**
     * Выбор семейства протоколов на основе параметра $this->type
     */
    protected function chooseDomain():void
    {
        switch ($this->Domain) {
            case "file" :
                $this->host = $this->path;
                $this->domain = AF_UNIX;
                break;
            case 'inet' :
                $this->domain = AF_INET;
                break;
            case 'inet6' :
                $this->domain = AF_INET6;
                break;
        }
    }

    /**
     * Инициализация сокета
     */
    protected function initSocket()
    {
        $this->chooseDomain();
        //TODO выполнить инициализацию сокета
    }

    /**
     * Чтение из потока (ввод с клавиатуры)
     * @return string
     */
    protected function readStream():string
    {
        return rtrim(fgets(STDIN));
    }

    /**
     * Приглашение на ввод сообщения
     * @return string
     */
    public function getMessage():string
    {
        echo 'Enter Message:';
        return $this->validateData($this->readStream());
    }

    /**
     * Возвращает строку без спец символов в начале и конце
     * @param $str
     * @return string
     * @throws \Exception
     */
    private function validateData($str):string
    {
        $str = (trim($str));
        if (empty($str)) {
            throw new \Exception("Data must be not empty", 1020);
        }
        return $str;
    }

}
