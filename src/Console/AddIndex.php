<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AddIndex extends Command
{
    protected static $defaultName = 'app:add_index';

    protected function configure(): void
    {
        $this
            ->setDescription('Добавляет индексы')
            ->setAliases(['index']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        App::getDb()->addIndex('video', 'channelId');
        return 0;
    }
}
