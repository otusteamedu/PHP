<?php

declare(strict_types=1);

namespace App\Command;

use UnexpectedValueException;

class Commands
{

    public static function get(): array
    {
        return [
            'create-indexes' => \App\Command\Indexes\CreateIndexesCommand::class,
            'delete-indexes' => \App\Command\Indexes\DeleteIndexesCommand::class,

            'run-crawler' => \App\Command\RunCrawlerCommand::class,

            'get-channels'   => \App\Command\Channel\GetCommand::class,
            'get-channel'    => \App\Command\Channel\GetOneCommand::class,
            'delete-channel' => \App\Command\Channel\DeleteCommand::class,

            'get-videos'   => \App\Command\Video\GetCommand::class,
            'get-video'    => \App\Command\Video\GetOneCommand::class,
            'delete-video' => \App\Command\Video\DeleteCommand::class,

            'get-likes-dislikes' => \App\Command\Channel\GetLikesDislikesCommand::class,
            'get-best-channels'  => \App\Command\Channel\GetBestChannelsCommand::class,
        ];
    }

    public static function has(string $commandName): bool
    {
        return !empty(self::get()[$commandName]);
    }

    public static function getClassName(string $commandName): string
    {
        if (!self::has($commandName)) {
            throw new UnexpectedValueException("Неизвестная команда {$commandName}");
        }

        return self::get()[$commandName];
    }

}