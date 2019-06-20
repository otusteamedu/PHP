<?php

namespace Otus;

class Config
{
    const SOCKET_DIR = 'sockets';
    const SERVER_SOCKET = 'srv.sock';
    const CLIENT_SOCKET = 'client{id}.sock';

    public static function getClientSocket($id)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self:: SOCKET_DIR . DIRECTORY_SEPARATOR .
            str_replace('{id}', $id, self::CLIENT_SOCKET);
    }

    public static function getServerSocket()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self:: SOCKET_DIR . DIRECTORY_SEPARATOR . self::SERVER_SOCKET;
    }
}
