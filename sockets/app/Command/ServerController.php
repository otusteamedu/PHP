<?php

namespace App\Command;

use App\Core\AbstractController;
use App\Model\ServerHandler;
use App\Model\UsersStorage;
use Exception;
use Socket\Raw\Factory as SocketFactory;

class ServerController extends AbstractController
{
    public function indexAction()
    {
        $address = $this->app()->getConfig()->getOrFail('socket');
        $factory = new SocketFactory();
        $socket = $factory->createServer($address);
        $storage = new UsersStorage('storage/users.ini');
        $handler = new ServerHandler($storage, $this->app()->logger());
        try {
            $handler->run($socket);
        } finally {
            $socket->close();
        }
    }
}