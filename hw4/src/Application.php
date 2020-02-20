<?php

namespace Chat;

class Application
{
    const CONFIG_FILE = "config.ini.php";
    const CMD_QUIT = "quit";

    private static $CONFIG = array();

    private $fileSock = "";
    private $fileSockOther = "";

    private $socket = null;
    private $mode = 0;


    public static function create()
    {
        $inst = new static();
        self::$CONFIG = require_once(self::CONFIG_FILE);

        if (!$inst->connect())
            return null;
        return $inst;
    }

    private function reciev()
    {
        socket_set_block($this->socket);
        echo "wait for message..." . PHP_EOL;
        socket_recvfrom($this->socket, $buf, 100, 0, $this->fileSockOther);
        return $buf;
    }

    private function getConsoleMsg()
    {
        echo "Your message(type " . self::CMD_QUIT . " to close application): ";
        $str = fgets(STDIN);
        $str = substr($str, 0, strlen($str)-1);
        return $str;
    }


    private function send($msg)
    {
        if (!file_exists($this->fileSockOther))
            return false;

        socket_set_nonblock($this->socket);
        return socket_sendto($this->socket, $msg, strlen($msg), 0, $this->fileSockOther);
    }

    private function isServer()
    {
        return $this->mode == 0;
    }


    public function run()
    {
        $isInit = $this->isServer();

        while(true) {

            if ($isInit) {
                $resp = $this->reciev();

                if ($resp == self::CMD_QUIT) {
                    $this->printCloseMsg();
                    break;
                }

                $this->printIncomeMsg($resp);
            }
            else
                $isInit = true;

            $msg = $this->getConsoleMsg();

            if ($msg == self::CMD_QUIT) {
                $this->send(self::CMD_QUIT); //send closing signal to other
                $this->printCloseMsg();
                break;
            }

            $this->send($msg);
        }
    }

    private function printIncomeMsg($msg)
    {
        echo "income message: $msg" . PHP_EOL . "-----" . PHP_EOL;
    }

    private function printCloseMsg()
    {
        echo "socket closing..." . PHP_EOL;
    }


    public function __destruct()
    {
        socket_close($this->socket);
        unlink($this->fileSock);
    }


    private function connect()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($this->socket === FALSE)
            return false;

        for ($mode = 0; $mode < 2; $mode++) {

            $fileSock = $this->getSockFile($mode);
            $fileSockOther = $mode == 0 ? '': $fileSockOther = $this->getSockFile(0);

            if (!file_exists($fileSock)) {
                $this->mode = $mode;
                $this->fileSock = $fileSock;
                $this->fileSockOther = $fileSockOther;
                return socket_bind($this->socket, $this->fileSock);
            }
        }

        return false;
    }


    private function getSockFile($mode)
    {
        $dir = self::$CONFIG['socket_dir'];
        return "$dir/file" . $mode . ".sock";
    }


}