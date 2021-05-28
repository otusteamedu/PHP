<?php


namespace App\Command;


use App\Consumer\ConsoleConsumer;
use App\Service\Messenger\ChannelBuilderInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RabbitWorkerCommand extends Command
{
    protected static string $defaultName = 'rabbit:worker';

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private ContainerInterface $container;

    /**
     * DoctrineCommand constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Rabbit worker.');
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->init();

        echo " [*] Ожидаю сообщения. Для выхода CTRL+C\n";

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();

        return Command::SUCCESS;
    }

    private function init(): void
    {
        /* @var ChannelBuilderInterface $channelBuilder */
        $channelBuilder = $this->container->get(ChannelBuilderInterface::class);
        $channelBuilder->setQueueName($this->container->get('queue_name'));

        $this->connection = $channelBuilder->getConnection();

        $this->channel = $channelBuilder->build();
        $this->channel->basic_consume(
            $channelBuilder->getQueueName(),
            '',
            false,
            false,
            false,
            false,
            new ConsoleConsumer
        );
    }
}

