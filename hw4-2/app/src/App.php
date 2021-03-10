<?php

declare(strict_types=1);

namespace App;

use App\Apps\AppTypes;
use App\Apps\ClientApp;
use App\Apps\ServerApp;
use App\Config\Configuration;
use App\Console\Console;
use App\Socket\Socket;
use App\Socket\Exceptions\SocketCreateException;
use App\Socket\ServerSocket;
use Exception;
use UnexpectedValueException;

class App
{

    private const PATH_TO_CONFIG_INI_FILE = '/Config/config.ini';
    
    public function run(): void
    {
        try {
            $appType = $this->getAppTypeFromCli();
            $this->assertAppTypeIsExist($appType);

            $config = $this->getConfig();

            switch ($appType) {
                case AppTypes::SERVER:
                    $this->startServerApp($config);
                    break;

                case AppTypes::CLIENT:
                    $this->startClientApp($config);
                    break;
            }
        } catch (Exception $e) {
            Console::error($e->getMessage());
        }
    }

    private function getAppTypeFromCli(): string
    {
        return !empty($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '';
    }

    private function assertAppTypeIsExist(string $appType)
    {
        if (!AppTypes::isExist($appType)) {
            $errorMessage = "Неизвестный параметр {$appType}. Необходимо указать один из следующих параметров: " . implode(', ', AppTypes::get());
            throw new UnexpectedValueException($errorMessage);
        }
    }

    private function getConfig(): Configuration
    {
        return new Configuration(__DIR__ . self::PATH_TO_CONFIG_INI_FILE);
    }

    /**
     * @param Configuration $config
     *
     * @throws SocketCreateException
     */
    private function startServerApp(Configuration $config): void
    {
        $serverSocket = ServerSocket::create(
            $config->getParam('address'),
            intval($config->getParam('port')),
            intval($config->getParam('maxConnection'))
        );

        (new ServerApp($serverSocket))->start();
    }

    /**
     * @param Configuration $config
     *
     * @throws SocketCreateException
     */
    private function startClientApp(Configuration $config): void
    {
        $socket = Socket::createFromAddress(
            $config->getParam('address'),
            intval($config->getParam('port')));

        (new ClientApp($socket))->start();
    }

}
