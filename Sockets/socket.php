<?php


namespace Sockets;


final class socket
{
    /**
     * объект для создаваемого сокета
     * @var \Socket
     */
    private \Socket $socket;
    /**
     * объект для сокета, к которому подсоединился клиент
     * @var \Socket
     */
    private \Socket $acceptedSocket;

    /**
     * socket constructor.
     * @param string $host
     * @param int $port
     * @param int $domain
     * @param int $type
     * @param int $protocol
     * @param int $maxConnections Максимальное количество соединений для сервера
     * @param int $buffer_length Длина буфера
     * @throws \Exception
     */
    public function __construct(
        private string $host,
        private int $port,
        private int $domain = AF_UNIX,
        private int $type = SOCK_STREAM,
        private int $protocol = 0,
        private int $maxConnections = 5,
        private int $buffer_length = 1024,
    )
    {
        // проверяем на наличие корректных входных данных
        if (!$this->host) {
            throw new \Exception('Host value required', 1010);
        }
        if (!$this->port) {
            throw new \Exception('Port value required', 1011);
        }
    }

    /**
     * Создает сокет
     * @throws \Exception
     */
    public function create():void
    {
        $this->socket = socket_create("$this->domain", "$this->type", "$this->protocol");
        if ($this->socket === false) {
            throw new \Exception("Can't create socket", 1000);
        }
    }

    /**
     * Закрывает сокет, содержащийся в $socket
     * @param $socket
     */
    private function close($socket):void
    {
        socket_set_option($socket, SOL_SOCKET, SO_LINGER, array('l_onoff' => 1, 'l_linger' => 0));
        socket_close($socket);
    }

    /**
     * Закрывает основной сокет ($this->socket)
     */
    public function closeSocket():void
    {
        $this->close($this->socket);
    }

    /**
     * Закрывает связанный с клиентом сокет
     * если параметр пустой, то закрывает сокет хранящийся в $this->acceptedSocket
     * для однопользовательской модели
     * @param null $acceptedSocket
     */
    public function closeAcceptedSocket($acceptedSocket = null):void
    {
        $acceptedSocket = $acceptedSocket ?? $this->acceptedSocket;
        $this->close($acceptedSocket);
    }

    /**
     * Привязывает сокет к адресу или файлу, в зависимости от типа сокета
     * @param string $address
     * @throws \Exception
     */
    public function bind($address = '127.0.0.1'):void
    {
        $bind = socket_bind($this->socket, $address, $this->port);
        if ($bind === false) {
            throw new \Exception(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
        }
    }

    /**
     * Забирает данные из сокета, хранимого в $this->socket
     * @return string
     * @throws \Exception
     */
    public function getFromSocket():string
    {
        try {
            return $this->read($this->socket);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * Отправляет данные в сокет $this->socket
     * @param $data
     * @throws \Exception
     */
    public function putToSocket($data):void
    {
        try {
            $this->write($this->socket, $data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * Запрашивает данные из сокета, связанного с клиентом
     * Если $acceptedSocket = null, то в качестве связанного сокета берется $this->acceptedSocket
     * для однопользовательской модели
     * @param null $acceptedSocket
     * @return string
     * @throws \Exception
     */
    public function getFromAcceptedSocket($acceptedSocket = null):string
    {
        $acceptedSocket = $acceptedSocket ?? $this->acceptedSocket;
        try {
            return $this->read($acceptedSocket);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * Отправляет данные $data в сокет $this->acceptedSocket
     * @param $data
     * @param null $acceptedSocket
     * @throws \Exception
     */
    public function putToAcceptedSocket($data, $acceptedSocket = null):void
    {
        $acceptedSocket = $acceptedSocket ?? $this->acceptedSocket;
        try {
            $this->write($acceptedSocket, $data);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(),$exception->getCode());
        }
    }

    /**
     * Забирает данные из сокета пришедшего в параметре $socket
     * @param $socket
     * @return string
     * @throws \Exception
     */
    private function read($socket): string
    {
        $socketData = socket_read($socket, $this->buffer_length);
        if ($socketData === false) {
            throw new \Exception("Can't read data from socket. " . socket_strerror(socket_last_error()),
                socket_last_error($this->socket));
        }

        if (!($socketData = trim($socketData))) {
            throw new \Exception("Can't read data from socket. Bad data", 1001);
        }
        return trim($socketData);
    }

    /**
     * Отправляет данные $data в сокет пришедший в параметре $socket
     * @param $socket
     * @param string $data
     * @throws \Exception
     */
    public function write($socket, string $data):void
    {
        $result = socket_write($socket, $data);
        if ($result === false) {
            throw new \Exception(
                "Can't to write to $this->host:$this->port, " . socket_strerror(socket_last_error($this->socket)),
                socket_last_error($this->socket));
        }
    }

    /**
     * Устанавливет прослушку для серверного сокета $this->socket
     * @throws \Exception
     */
    public function listen():void
    {
        if (socket_listen($this->socket, $this->maxConnections) === false) {
         throw new \Exception(
             "Can't to listen at $this->host:$this->port, " . socket_strerror(socket_last_error($this->socket)),
             socket_last_error($this->socket));
        }
    }

    /**
     * Устанавливает соединение сокета $this->socket с сервером
     * @throws \Exception
     */
    public function connect():void
    {
        if (socket_connect($this->socket, $this->host, $this->port) === false) {
            throw new \Exception(
                "Can't to connect to socket $this->host:$this->port, " .socket_strerror(socket_last_error($this->socket)),
                socket_last_error($this->socket));
        };
        echo "Соединение с сервером установлено\n";
    }

    /**
     * Ждет когда к сокету кто-нибудь подсоединиться
     * @param bool $acceptBlockMode если 'true' блокирует дальнейшее действие скрипта до возникновения соединения
     * @return false|resource|\Socket
     * @throws \Exception
     */
    public function accept($acceptBlockMode = true)
    {
        if (!$acceptBlockMode) {
            if (socket_set_nonblock($this->socket) === false ) {
                throw new \Exception(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
            }
            return socket_accept($this->socket);
        }
        $this->acceptedSocket = socket_accept($this->socket);
    }

    /**
     * возвращает сокеты в которых пришло сообщение
     * @param null $read
     * @param null $write
     * @param null $exept
     * @return array|mixed|null
     * @throws \Exception
     */
    public function select($read= null, $write = null, $exept = null)
    {
        if (!$read&&!$write&&!$exept) {
            return [];
        }
        if (!$read) {
            $read = [$this->acceptedSocket];
        }
        if (false === socket_select($read, $write, $exept, 0)) {
            throw new \Exception(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
        }
        return $read;
    }

}