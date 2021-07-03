<?php
class Sender
{
    public $socket;
    public $errno;
    public $errstr;
    public $unix = 'unix:///tmp/test.sock';
    public function __construct($argc)
    {
        $this->socket = stream_socket_client($this->unix, $errno, $errstr);
        $this->errno = $errno;
        $this->errstr = $errstr;
        if ($argc == 1) {
            exit("not input");
        } else if ($argc == 2) {
            exit("one input");
        } else if ($argc > 3) {
            exit("many input");
        }
    }
    public function checkConnect()
    {
        if (!$this->socket) {
            exit("$this->errstr ($this->errno)<br/>\n");
        }
    }
    public function fileRead_1()
    {
        echo fread($this->socket, 1024);
    }
    public function fileWriteArgV_1($argv)
    {
        fwrite($this->socket,  $argv . "\n");
    }
    public function fileRead_2()
    {
        echo fread($this->socket, 1024);
    }
    public function fileWriteArgV_2($argv)
    {
        fwrite($this->socket, $argv . "\n");
    }
    public function fileClose()
    {
        fclose($this->socket);
    }
}
$soc = new Sender($argc);

$soc->checkConnect();
$soc->fileRead_1();
$soc->fileWriteArgV_1($argv[1]);
$soc->fileRead_2();
$soc->fileWriteArgV_2($argv[2]);
$soc->fileClose();
