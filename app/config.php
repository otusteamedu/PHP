<?php
namespace Otus\Azatnizam;

class Config {
    const UNIX_SOCKET_FILE = 'chat.socket';

    const UNIX_RESPONSE_SOCKET_FILE = 'response.chat.socket';

    static function getSocketName() {
        return self::UNIX_SOCKET_FILE;
    }

    static function getResponseSocketName() {
        return self::UNIX_RESPONSE_SOCKET_FILE;
    }
}
