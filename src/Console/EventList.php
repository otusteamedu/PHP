<?php

namespace App\Console;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class EventList extends Command
{
    protected static $defaultName = 'app:list';

    protected function configure(): void
    {
        $this
            ->addArgument('pattern', InputArgument::OPTIONAL, 'pattern', 'event:*')
            ->setDescription('Scan Redis keys');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pattern = $input->getArgument('pattern');
        $res = App::getRedis()->keys($pattern);
        $io = new SymfonyStyle($input, $output);
        $io->listing($res);
        return 0;
    }
}
