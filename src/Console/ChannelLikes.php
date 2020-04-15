<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ChannelLikes extends Command
{
    protected static $defaultName = 'app:channel_likes';

    protected function configure(): void
    {
        $this
            ->setDescription('Суммарное кол-во лайков и дизлайков для канала по всем его видео')
            ->addArgument('id', InputArgument::REQUIRED, 'ID канала')
            ->setAliases(['chan']);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = (string) $input->getArgument('id');
        $data = App::getDb()->getChannelLikes($id);

        $asArray = [];
        $i = 0;
        foreach ($data as $row) {
            $asArray[$i] = [
                $row['like'],
                $row['dislike'],
            ];
            $i++;
        }
        $io->table(['Like', 'Dislike'], $asArray);

        return 0;
    }
}
