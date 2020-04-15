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

        $data = self::getTop(App::getDb(), $limit);

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

    private static function getTop(Db $db, int $limit): Traversable
    {
        $pipe = [
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
                    'channelId' => '$_id',
                    'ratio' => ['$divide' => ['$like', ['$cond' => ['$dislike', '$dislike', 1]]]],
                    '_id' => 0,
                ],
            ],
            [
                '$sort' => [
                    'ratio' => -1,
                ],
            ],
            [
                '$limit' => $limit,
            ],
            [
                '$lookup' => [
                    'from' => 'channel',
                    'localField' => 'channelId',
                    'foreignField' => '_id',
                    'as' => 'channel',
                ],
            ],
            [
                '$project' => [
                    'channel' => ['$arrayElemAt' => ['$channel', 0]],
                    'ratio' => '$ratio',
                ],
            ],
            [
                '$project' => [
                    'channel' => '$channel.title',
                    'ratio' => '$ratio',
                ],
            ],
        ];
        return $db->aggregate('video', $pipe);
    }
}
