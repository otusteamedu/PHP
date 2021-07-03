<?php
class Receiver
{
    public $socket;
    public $unlink = '/tmp/test.sock';
    public $unix = 'unix:///tmp/test.sock';
    public $errno;
    public $errstr;
    public $socketAccept;
    public function __construct()
    {
        @unlink($this->unlink);
        $this->socket = stream_socket_server($this->unix, $errno, $errstr);
        $this->errno = $errno;
        $this->errstr = $errstr;
    }

    public function checkConnect()
    {
        if (!$this->socket) {
            echo "$this->errstr ($this->errno)<br/>\n";
        }
    }
    public function connectAccept()
    {

        $this->socketAccept = stream_socket_accept($this->socket, -1);
    }
    public function fileWriteArgV_1()
    {
        fwrite($this->socketAccept,  'Local time' . date('n/j/Y g:i a') . "\n");
    }
    public function fileRead_1()
    {
        echo fread($this->socketAccept, 1024);
    }

    public function fileWriteArgV_2()
    {
        fwrite($this->socketAccept, 'Local time' . date('n/j/Y g:i a') . "\n");
    }
    public function fileRead_2()
    {
        echo fread($this->socketAccept, 1024);
    }
    public function acceptClose()
    {
        fclose($this->socketAccept);
    }
    public function fileClose()
    {
        fclose($this->socket);
    }
}
$soc = new Receiver();


$soc->checkConnect();
$soc->connectAccept();
$soc->fileWriteArgV_1();
$soc->fileRead_1();
$soc->fileWriteArgV_2();
$soc->fileRead_2();
$soc->acceptClose();
$soc->fileClose();
