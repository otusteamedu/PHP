<?php


namespace App\Utils;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;


class Config
{
    const CONFIG_DIR = 'config';
    private string $configDir;
    private bool $test;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->configDir =
            dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . self::CONFIG_DIR;
    }


    /**
     * @throws \Exception
     */
    public function buildContainer($cli = false): ContainerInterface
    {
        $builder = new ContainerBuilder();

        $services = $cli ? 'services-cli.php' : 'services.php';

        $builder->addDefinitions(
            $this->getRealPath($services),
            $this->getRealPath('settings.php'),
        );
        return $builder->build();
    }



    private function getRealPath(string $filename): string
    {
        return $this->configDir . DIRECTORY_SEPARATOR . $filename;
    }

}
