<?php

namespace Socket;

use Exception;

/**
 * Class SocketCreator
 *
 * @package Socket
 */
class SocketCreator
{
    /**
     * @return resource|\Socket
     * @throws Exception
     */
    public static function make ()
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if ($socket === false) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        return $socket;
    }
}