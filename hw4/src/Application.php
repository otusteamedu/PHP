<?php

namespace Chat;

class Application
{
    const CONFIG_FILE = "config.ini.php";
    const CMD_QUIT = "quit";
    const CMD_QUIT_ON_DEMAND = "quit_demand";

    const MODE_SERVER = 1;
    const MODE_CLIENT = 2;

    private static $_CONFIG = array();

    private $_fileSock = "";
    private $_fileSockOther = "";

    private $_socket = null;
    private $_mode = self::MODE_SERVER;


    public static function create()
    {
        $inst = new static();
        self::$_CONFIG = require_once(self::CONFIG_FILE);

        if (!$inst->connect())
            return null;
        return $inst;
    }

    private function reciev()
    {
        socket_set_block($this->_socket);
        echo "wait for message..." . PHP_EOL;
        socket_recvfrom($this->_socket, $buf, 100, 0, $this->_fileSockOther);
        return $buf;
    }

    private function getConsoleMsg()
    {
        echo "Your message(type 'quit' to close application): ";
        $str = fgets(STDIN);
        $str = substr($str, 0, strlen($str)-1);
        return $str;
    }


    private function send($msg)
    {
        if (!file_exists($this->_fileSockOther))
            return false;

        socket_set_nonblock($this->_socket);
        return socket_sendto($this->_socket, $msg, strlen($msg), 0, $this->_fileSockOther);
    }

    private function isServer()
    {
        return $this->_mode == self::MODE_SERVER;
    }


    public function run()
    {
        $isInit = $this->isServer();

        while(true) {

            if ($isInit) {
                $resp = $this->reciev();

                if ($resp == self::CMD_QUIT_ON_DEMAND) {
                    $this->printCloseMsg();
                    break;
                }

                $this->printIncomeMsg($resp);
            }
            else
                $isInit = true;

            $msg = $this->getConsoleMsg();

            if ($msg == self::CMD_QUIT) {
                $this->send(self::CMD_QUIT_ON_DEMAND); //send closing signal to other
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
        socket_close($this->_socket);
        unlink($this->_fileSock);
    }


    private function connect()
    {
        $this->_socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($this->_socket === FALSE)
            return false;

        for ($mode = self::MODE_SERVER; $mode <= self::MODE_CLIENT; $mode++) {

            $fileSock = $this->getSockFile($mode);
            //echo "------ $fileSock --------".PHP_EOL.PHP_EOL;
            $fileSockOther = '';

            if ($mode == self::MODE_CLIENT)
                $fileSockOther = $this->getSockFile(self::MODE_SERVER);

            if (!file_exists($fileSock)) {
                echo "------ $fileSock --------".PHP_EOL.PHP_EOL;
                $this->_mode = $mode;
                $this->_fileSock = $fileSock;
                $this->_fileSockOther = $fileSockOther;
                socket_bind($this->_socket, $this->_fileSock);
                return true;
            }
        }

        return false;
    }


    private function getSockFile($mode)
    {
        $dir = self::$_CONFIG['socket_dir'];
        return "$dir/file" . $mode . ".sock";
    }


}