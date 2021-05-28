<?php


namespace App\Console;


use App\Command\FakerUsersCommand;
use App\Command\RabbitWorkerCommand;
use App\Command\RabbitSendCommand;
use App\Service\Security\SecurityInterface;
use App\Utils\Config;
use Doctrine\ORM\EntityManager;
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
        $this->container = $config->buildContainer(true);

        $em = $this->container->get(EntityManager::class);
        $security = $this->container->get(SecurityInterface::class);

        $this->addCommands([
            new FakerUsersCommand($em, $security),
            new RabbitSendCommand($this->container),
            new RabbitWorkerCommand($this->container),
        ]);
    }


}
