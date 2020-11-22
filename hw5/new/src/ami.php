<?php

namespace asterisk;

class AsteriskAMI
{
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
        $this->host  = $host;
        $this->port  = $port;
        $this->login = $user;
        $this->pass  = $pass;

        if ($this->connect() && $this->connection) {
            sleep(2);
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
            stream_set_timeout($this->connection, 0, 400000);
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
            $this->lastActionId = rand(10000000000000000, 99999999900000000);
            fwrite($this->connection, sprintf("ActionID: %s\r\n%s\r\n\r\n", $this->lastActionId, $msg));
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
            $b = [];
            $k = 0;
            $s = "";
            $this->sleepi();
            do {
                $s .= fread($this->connection, 1024);
                sleep(0.005);
                $mmm = socket_get_status($this->connection);
            } while ($mmm['unread_bytes']);

            $mm             = explode("\r\n", $s);
            $this->lastRead = [];

            for ($i = 0; $i < count($mm); $i++) {
                if ($mm[$i] == "") {
                    $k++;
                }
                $m = explode(":", $mm[$i]);
                if (isset($m[1])) {
                    $this->lastRead[$k][trim($m[0])] = trim($m[1]);
                }
            }
            unset ($b);
            unset ($k);
            unset ($mm);
            unset ($mm);
            unset ($mmm);
            unset ($i);
            unset ($s);

            return $this->lastRead;
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
        return $this->write(sprintf("Action: Login\r\nUsername: %s\r\nSecret: %s\r\n\r\n", $this->login, $this->pass));
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
