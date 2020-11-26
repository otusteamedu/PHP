<?php

namespace asterisk;
/**
 * Class asterisk\ami
 *
 * @see https://habr.com/ru/post/253387/
 */
class AsteriskAMI
{
    public $ini = [];


    /**
     * AsteriskAMI constructor.
     *
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $pass
     */
    function __construct($host, $port, $user, $pass)
    {
        $this->ini["con"]          = false;
        $this->ini["host"]         = $host;
        $this->ini["port"]         = $port;
        $this->ini["lastActionID"] = 0;
        $this->ini["lastRead"]     = [];
        $this->ini["sleep_time"]   = 1.5;
        $this->ini["login"]        = $user;
        $this->ini["password"]     = $pass;

        if ($this->connect() && $this->ini['con']) {
            sleep(2);
            $this->read();
            $this->init();
        }
    }


    function __destruct()
    {
        $this->disconnect();
        unset ($this->ini);
    }


    /**
     * Connect to Asterisk Server
     */
    public function connect()
    {
        $this->ini["con"] = fsockopen($this->ini["host"], $this->ini["port"], $a, $b, 10);
        if ($this->ini["con"]) {
            stream_set_timeout($this->ini["con"], 0, 400000);
        } else {
            return false;
        }
    }


    /**
     *
     * @return bool
     */
    public function connected(){
        return ! empty($this->ini['con']);
    }

    /**
     * Disconnect from server
     */
    public function disconnect()
    {
        if ($this->ini["con"]) {
            fclose($this->ini["con"]);
        }
    }


    /**
     * Send message to server
     *
     * @param string $a
     *
     * @return int action ID
     */
    public function write($a)
    {
        if ( ! empty($this->ini['con'])) {
            $this->ini["lastActionID"] = rand(10000000000000000, 99999999900000000);
            fwrite($this->ini["con"], "ActionID: " . $this->ini["lastActionID"] . "\r\n$a\r\n\r\n");
            $this->sleepi();

            return $this->ini["lastActionID"];
        } else {
            return false;
        }
    }


    /**
     * Sleep before send new message
     */
    public function sleepi()
    {
        sleep($this->ini["sleep_time"]);
    }


    /**
     * Read message from server
     *
     * @return string[]
     */
    public function read()
    {
        if ( ! empty($this->ini['con'])) {
            $b = [];
            $k = 0;
            $s = "";
            $this->sleepi();
            $mm = [];
            do {
                $s .= fread($this->ini["con"], 1024);
                //$s .= fgets($this->ini["con"]);
                //$mm[] = stream_get_line($this->ini["con"], 1024, "\r\n");
                sleep(0.005);
                $mmm = socket_get_status($this->ini["con"]);
            } while ($mmm['unread_bytes']);
            $mm                    = explode("\r\n", $s);
            $this->ini["lastRead"] = [];
            for ($i = 0; $i < count($mm); $i++) {
                //$mm[$i] = str_replace("\r\n", "", $mm[$i]);
                if ($mm[$i] == "") {
                    $k++;
                }
                $m = explode(":", $mm[$i]);
                if (isset($m[1])) {
                    $this->ini["lastRead"][$k][trim($m[0])] = trim($m[1]);
                }
            }
            unset ($b);
            unset ($k);
            unset ($mm);
            unset ($mm);
            unset ($mmm);
            unset ($i);
            unset ($s);

            return $this->ini["lastRead"];
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
        return $this->write("Action: Login\r\nUsername: " . $this->ini["login"] . "\r\nSecret: " . $this->ini["login"] . "\r\n\r\n");
    }
}
