<?php

namespace App\Command;

use App\Core\AbstractController;
use App\Model\ClientHandler;
use Socket\Raw\Factory as SocketFactory;

class ClientController extends AbstractController
{
    public function indexAction()
    {
        $factory = new SocketFactory();
        $address = $this->app()->getConfig()->getOrFail('socket');
        $socket = $factory->createClient($address);
        $handler = new ClientHandler($this->app()->logger());
        $command = $_SERVER['argv'][2] ?? null;
        $parameters = $_SERVER['argv'][3] ?? null;
        $handler->execute($socket, $command, $parameters);
    }
}