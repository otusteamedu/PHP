<?php


namespace App\Command;



use App\Utils\Builder\AMQPChannelBuilderInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerBankOperationCommand extends Command
{
    protected static string $defaultName = 'consumer:bank-operation';

    private AMQPChannel $channel;
    private string $queue;
    private ContainerInterface $container;
    private LoggerInterface $logger;


    /**
     * ConsumerBankOperationCommand constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
        $channelBuilder = $container->get(AMQPChannelBuilderInterface::class);
        $this->channel = $channelBuilder->build();
        $this->queue = $channelBuilder->getQueueName();
        $this->logger = $container->get(LoggerInterface::class);
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->init();

        echo ' [*] Ожидаю сообщения. Для выхода CTRL+C', PHP_EOL;

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->channel->getConnection()->close();

        return Command::SUCCESS;
    }


    private function init(): void
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            false,
            false,
            false,
            fn($msg) => $this->callback($msg)
        );
    }

    private function callback($msg)
    {
        echo ' [x] Получено сообщение: ', $msg->body, PHP_EOL;

        try {
            /** @var \App\Message\MessageInterface $message */
            $message = unserialize(json_decode($msg->body, true));

            $handlerClass = $message->getHandler();
            $handler = new $handlerClass($this->container);
            $handler->process($message);

            echo ' [x] Обработано', PHP_EOL;

        } catch (\Exception $e) {
            $errorMessage = $msg->body . "\t" . $e->getMessage();
            $this->logger->error($errorMessage);

            echo ' [x] Ошибка обработки', PHP_EOL;
        }

        $msg->ack();
    }


}
