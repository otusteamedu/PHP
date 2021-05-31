<?php


namespace App\Sockets\Interfaces;


interface iSocketConnected
{
    public function read(int $length = 1024, int $type = PHP_BINARY_READ);

    public function write(string $message): iSocketConnected;

    public function shutdown(int $mode = 2);

    public function close();
}