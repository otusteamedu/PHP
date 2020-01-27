<?php

declare(strict_types=1);

namespace Socket\Ruvik\Service;

use Socket\Ruvik\Controller\ControllerInterface;
use Socket\Ruvik\DTO\InputArgs;
use Socket\Ruvik\DTO\SocketConfig;
use Socket\Ruvik\Exception\RuntimeException;

class Router
{
    /**
     * @var IniManager
     */
    private $iniManager;
    /**
     * @var SocketConfig
     */
    private $socketConfig;

    public function __construct(IniManager $iniManager)
    {
        $this->iniManager = $iniManager;
//        $this->socketConfig = $socketConfig;
    }

    public function getController(InputArgs $inputArgs): ControllerInterface
    {
        if (! isset($this->iniManager->getRoute()->getRoutes()[$inputArgs->getEnv()])) {
            throw new RuntimeException('Route undefined');
        }

        try {
            dump([
                $this->iniManager->getRoute()->getRoutes(),
                $inputArgs->getEnv()
            ]);
//            return new ($this->iniManager->getRoute()[$inputArgs->getEnv()]);
            die('die');
        } catch (\Throwable $exception) {
            dump($exception);
            die('finish');
        }

    }
}
