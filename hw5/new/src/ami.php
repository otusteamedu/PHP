<?php

namespace asterisk;

class AsteriskAMI
{
    const CONNECT_TIMEOUT = 180000;
    private $connection;
    private $host;
    private $port         = '5038';
    private $user;
    private $pass;
    private $lastActionId = 0;
    private $lastRead     = [];
    private $sleepTime    = 1.5;


    /**
     * AsteriskAMI constructor.
     *
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $pass
     */
    function __construct(string $host, string $port, string $user, string $pass)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;

        if ($this->connect() && $this->connection) {
            $this->read();
            $this->init();
        }
    }


    function __destruct()
    {
        $this->disconnect();
        unset ($this->connection);
    }


    /**
     * Connect to Asterisk Server
     */
    public function connect()
    {
        $this->connection = fsockopen($this->host, $this->port, $a, $b, 10);
        if ($this->connection) {
            stream_set_timeout($this->connection, 0, self::CONNECT_TIMEOUT);
        } else {
            return false;
        }
    }


    /**
     *
     * @return bool
     */
    public function connected()
    {
        return ! empty($this->connection);
    }


    /**
     * Disconnect from server
     */
    public function disconnect()
    {
        if ($this->connection) {
            fclose($this->connection);
        }
    }


    /**
     * Send message to server
     *
     * @param string $msg
     *
     * @return int action ID
     */
    public function write(string $msg)
    {
        if ( ! empty($this->connection)) {
            $this->lastActionId++;
            fwrite($this->connection, sprintf("ActionID: %s\r\n%s\r\n\r\n", $this->lastActionId, $msg));
            // после отправки сообщения, нужно подождать, что-бы сервер успел выполнить команды, иначе может разорвать соединение
            $this->sleepi();

            return $this->lastActionId;
        } else {
            return false;
        }
    }


    /**
     * Sleep before send new message
     */
    public function sleepi()
    {
        sleep($this->sleepTime);
    }


    /**
     * Read message from server
     *
     * @return string[]
     */
    public function read()
    {
        if ( ! empty($this->connection)) {
            // номер сообщения в ответе
            $k   = 0;
            $buf = "";
            $this->sleepi();
            // получаем данные из сокета
            do {
                $buf .= fread($this->connection, 1024);
                sleep(0.005);
                $socketStatus = socket_get_status($this->connection);
            } while ($socketStatus['unread_bytes']);

            // преобразовываем в массив
            $lines          = explode("\r\n", $buf);
            $this->lastRead = [];

            for ($i = 0; $i < count($lines); $i++) {
                if ($lines[$i] == "") {
                    // есть новое сообщение
                    $k++;
                }
                [$action, $msg] = explode(":", $lines[$i]);
                if (isset($msg)) {
                    $action                      = trim($action);
                    $this->lastRead[$k][$action] = trim($msg);
                }
            }
            unset ($k);
            unset ($lines);
            unset ($socketStatus);
            unset ($i);
            unset ($buf);

            return array_filter($this->lastRead);
        } else {
            return false;
        }
    }


    /**
     * Authorize on Asterisk AMI service
     *
     * @return int
     */
    public function init()
    {
        return $this->write(sprintf("Action: Login\r\nUsername: %s\r\nSecret: %s\r\n\r\n", $this->user, $this->pass));
    }


    /**
     * Установить задержку между сообщениями
     *
     * @param float $t
     */
    public function sleepTime(float $t)
    {
        $this->sleepTime = (float)$t;
    }
}
