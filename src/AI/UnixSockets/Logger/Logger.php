<?php
namespace AI\backend_php_hw4\UnixSockets\Logger;

class Logger
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $_SERVER['PWD'].'/'.$filename;
    }

    public function add($message)
    {
        $message = date('Y-m-d H:i:s').' '.$message.PHP_EOL;
        file_put_contents($this->filename, $message, FILE_APPEND);
    }
}