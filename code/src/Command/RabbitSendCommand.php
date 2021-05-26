<?php


namespace App\Command;


use App\Service\Messenger\ChannelBuilderInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RabbitSendCommand extends Command
{
    const ARG_MESSAGE = 'message';

    protected static string $defaultName = 'rabbit:send';

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $queueName;
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
            ->setDescription('Send message.')
            ->addArgument(self::ARG_MESSAGE, InputArgument::IS_ARRAY, 'The message');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->init();

        $message = $input->getArgument(self::ARG_MESSAGE)
            ? implode(' ', $input->getArgument(self::ARG_MESSAGE))
            : 'Hello world!';


        $msg = new AMQPMessage($message, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->channel->basic_publish($msg, '', $this->queueName);

        echo sprintf('Отправлено: "%s",%s', $message, PHP_EOL);

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
        $this->queueName = $channelBuilder->getQueueName();

        $this->channel = $channelBuilder->build();
    }

}
