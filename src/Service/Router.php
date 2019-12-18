<?php

declare(strict_types=1);

namespace Service;

use Controller\ClientController;
use Controller\ControllerInterface;
use Controller\ServerController;
use Exception;

class Router
{
    /**
     * @param string $command
     * @return ControllerInterface
     * @throws Exception
     */
    public function resolveCommand(string $command): ControllerInterface
    {
        $socketProvider = new SocketProvider();
        $configProvider = new ConfigProvider('config/socket.ini');

        if ($command === 'client/start') {
            return new ClientController($socketProvider, $configProvider);
        } elseif ($command === 'server/start') {
            return new ServerController($socketProvider, $configProvider);
        } else {
            throw new Exception("Command {$command} not found");
        }
    }
}