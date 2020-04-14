<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChannelLikes extends Command
{
    protected static $defaultName = 'app:channel_likes';

    protected function configure(): void {
        $this
            ->setDescription('Суммарное кол-во лайков и дизлайков для канала по всем его видео')
            ->addArgument('id', InputArgument::REQUIRED, 'ID канала')
            ->setAliases(['chan'])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = (string) $input->getArgument('id');
        $pipe = [
            [
                '$match'=> ['channelId'=> $id]
            ],
            [
                '$group'=> [
                    '_id'=> '$channelId',
                    'like'=> [
                        '$sum'=> ['$convert'=> ['input'=> '$statistics.likeCount', 'to'=> 'int']]
                    ],
                    'dislike'=> [
                        '$sum'=> ['$convert'=> ['input'=> '$statistics.dislikeCount', 'to'=> 'int']]
                    ],
                ]
            ],
            [
                '$project'=> [
                    'like'=> '$like',
                    'dislike'=> '$dislike',
                    '_id'=> 0,
                ]
            ]
        ];
        $app = new App();
        $result = $app->db->aggregate('video', $pipe);

        $asArray = [];
        $i = 0;
        foreach ($result as $row) {
            $asArray[$i] = [
                $row['like'],
                $row['dislike'],
            ];
            $i++;
        }

        $io = new SymfonyStyle($input, $output);
        $io->table(['Like', 'Dislike'], $asArray);
        return 0;
    }
}
