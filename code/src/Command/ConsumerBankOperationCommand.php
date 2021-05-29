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
    const MESSAGE_EXPECT = ' [*] Ожидаю сообщения. Для выхода CTRL+C';
    const MESSAGE_DELIVERY = ' [x] Получено сообщение: ';
    const MESSAGE_PROCESSED = ' [x] Обработано';
    const MESSAGE_ERROR = ' [!] Ошибка обработки: ';


    protected static $defaultName = 'consumer:bank-operation';

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
        $this->logger = $container->get(LoggerInterface::class);
        $channelBuilder = $container->get(AMQPChannelBuilderInterface::class);

        $this->channel = $channelBuilder->build();
        $this->queue = $channelBuilder->getQueueName();
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->init();

        echo self::MESSAGE_EXPECT, PHP_EOL;

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
        echo self::MESSAGE_DELIVERY, $msg->body, PHP_EOL;

        try {
            /** @var \App\Message\MessageInterface $message */
            $message = unserialize(json_decode($msg->body, true));

            $handlerClass = $message->getHandler();
            $handler = $this->container->get($handlerClass);
            $handler->process($message);

            echo self::MESSAGE_PROCESSED, PHP_EOL;

        } catch (\Exception $e) {
            $exception = sprintf(
                '%s (%s: %s)',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
            $errorMessage = $msg->body . "\t" . $exception;
            $this->logger->error($errorMessage);

            echo self::MESSAGE_ERROR, PHP_EOL, $exception, PHP_EOL;
        }

        $msg->ack();
    }


}
