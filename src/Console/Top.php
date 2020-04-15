<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Top extends Command
{
    protected static $defaultName = 'app:top';

    protected function configure(): void
    {
        $this
            ->setDescription('Топ N каналов по соотношению лайки/дизлайки')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Кол-во каналов в топе', 5)
            ->setAliases(['top']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $limit = $input->getArgument('limit');
        if (false === filter_var($limit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            $io->error('Кол-во каналов в топе должна быть целым положительным числом');
            return 0;
        }

        $data = App::getDb()->getTopChannels($limit);

        $asArray = [];
        $i = 0;
        foreach ($data as $row) {
            $asArray[$i] = [
                $row['channel'],
                $row['ratio'],
            ];
            $i++;
        }
        $io->table(['Channel', 'Ratio'], $asArray);

        return 0;
    }
}
