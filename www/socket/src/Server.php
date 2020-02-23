<?php

namespace App;

use Exception;

/**
 * Class Server
 * @package App
 */
class Server
{
    /**
     *
     * @throws Exception
     */
    public function start()
    {
        if (file_exists(getenv('FILE_PATH_SOCKET_SERVER'))) {
            unlink(getenv('FILE_PATH_SOCKET_SERVER'));
        }

        $socket = new Socket(getenv('FILE_PATH_SOCKET_SERVER'));

        $socket->create();

        $socket->bind();

        Message::output('Server started.');

        while(1)
        {
            $socket->block();

            $bucket = $socket->receive();

            Message::output('client:' . $bucket);

            $socket->unblock();

            $socket->send('Accepted', getenv('FILE_PATH_SOCKET_CLIENT'));

        }

        Message::output('Server stopped');

        $socket->unbind();
    }

}
