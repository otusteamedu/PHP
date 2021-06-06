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
    public function buildContainer(): ContainerInterface
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions(
            $this->getRealPath('services.php'),
            $this->getRealPath('settings.php'),
        );
        return $builder->build();
    }

    public function addVarDumper(): void
    {
        require_once $this->getRealPath('var-dumper.php');
    }



    private function getRealPath(string $filename): string
    {
        return $this->configDir . DIRECTORY_SEPARATOR . $filename;
    }

}
