<?php
declare(strict_types=1);

namespace App\Commands;

use App\Clients\RabbitClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportsConsumerCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'consumer:reports';

    /**
     * @var RabbitClient
     */
    private RabbitClient $rabbitClient;

    /**
     * ReportsConsumerCommand constructor.
     *
     * @param RabbitClient $rabbitClient
     */
    public function __construct(RabbitClient $rabbitClient)
    {
        parent::__construct();
        $this->rabbitClient = $rabbitClient;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Runs consumer of reports')
            ->setHelp('Runs consumer of reports...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->rabbitClient->initialize();
        $this->rabbitClient->consume();
        $this->rabbitClient->wait();

        return Command::SUCCESS;
        // return Command::FAILURE;
    }
}
