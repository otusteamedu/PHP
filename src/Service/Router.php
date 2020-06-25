<?php

declare(strict_types=1);

namespace HomeWork\Service;

use Exception;
use HomeWork\Controller\ClientController;
use HomeWork\Controller\ControllerInterface;
use HomeWork\Controller\ServerController;
use HomeWork\Factory\ConfigFactory;
use HomeWork\Factory\UdpSocketFactory;

class Router
{
    /**
     * @param string $command
     * @return ControllerInterface
     * @throws Exception
     */
    public function resolveCommand(string $command): ControllerInterface
    {
        $config = (new ConfigFactory(ROOT . 'config/config.ini'))->create();
        $factory = new UdpSocketFactory();

        if ($command === 'client/start') {
            return new ClientController($config, $factory);
        } elseif ($command === 'server/start') {
            return new ServerController($config, $factory);
        } else {
            throw new Exception("Command {$command} not found");
        }
    }
}
