<?php


namespace App\Console;


use App\Command\FakerUsersCommand;
use App\Command\RabbitSendExchangeCommand;
use App\Command\RabbitWorkerCommand;
use App\Command\RabbitSendCommand;
use App\Command\RabbitWorkerExchangeCommand;
use App\Utils\Config;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class App extends Application
{
    private ContainerInterface $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $config = new Config;
        $this->container = $config->buildContainer();

        $faker = Factory::create('ru_RU');
        $em = $this->container->get(EntityManager::class);

        $this->addCommands([
            new FakerUsersCommand($em, $faker),
            new RabbitSendCommand($this->container),
            new RabbitWorkerCommand($this->container),
            new RabbitWorkerExchangeCommand($this->container),
            new RabbitSendExchangeCommand($this->container),
        ]);
    }


}
