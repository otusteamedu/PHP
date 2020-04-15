<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\App;
use App\Db;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Traversable;

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
        $data = self::getLikes(App::getDb(), $id);

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

    private static function getLikes(Db $db, string $id): Traversable
    {
        $pipe = [
            [
                '$match' => ['channelId' => $id],
            ],
            [
                '$group' => [
                    '_id' => '$channelId',
                    'like' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.likeCount', 'to' => 'int']],
                    ],
                    'dislike' => [
                        '$sum' => ['$convert' => ['input' => '$statistics.dislikeCount', 'to' => 'int']],
                    ],
                ],
            ],
            [
                '$project' => [
                    'like' => '$like',
                    'dislike' => '$dislike',
                    '_id' => 0,
                ],
            ],
        ];
        return $db->aggregate('video', $pipe);
    }
}
