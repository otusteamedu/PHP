<?php


namespace App\Console;


use App\Command\CreateBankOperationCommand;
use App\Command\ConsumerBankOperationCommand;
use App\Command\CreateUsersCommand;
use App\Command\RabbitWorkerCommand;
use App\Command\RabbitSendCommand;
use App\Message\BankOperationMessage;
use App\Service\Message\AMQPChannelBuilderInterface;
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
        $this->container = $config->buildContainer();

        $em = $this->container->get(EntityManager::class);
        $security = $this->container->get(SecurityInterface::class);


        $this->addCommands([
            new ConsumerBankOperationCommand($this->container),
            new CreateUsersCommand($em, $security),
            new CreateBankOperationCommand($em),
        ]);
    }


}
