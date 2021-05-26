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
    public function __construct(bool $test = false)
    {
        $this->configDir =
            dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . self::CONFIG_DIR;
        $this->test = $test;
    }


    /**
     * @throws \Exception
     */
    public function buildContainer(): ContainerInterface
    {
        $builder = new ContainerBuilder();

        $settings = $this->test ? 'settings-test.php' : 'settings.php';

        $builder->addDefinitions(
            $this->getRealPath('services.php'),
            $this->getRealPath($settings),
        );
        return $builder->build();
    }

    private function getRealPath(string $filename): string
    {
        return $this->configDir . DIRECTORY_SEPARATOR . $filename;
    }

}
