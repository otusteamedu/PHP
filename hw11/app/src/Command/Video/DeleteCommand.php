<?php

declare(strict_types=1);

namespace App\Command\Video;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Video\UseCase\Delete\DeleteVideoCommand;
use App\Model\Video\UseCase\Delete\DeleteVideoHandler;
use InvalidArgumentException;

class DeleteCommand implements CommandInterface
{

    private DeleteVideoHandler $deleteVideoHandler;

    public function __construct(DeleteVideoHandler $deleteVideoHandler)
    {
        $this->deleteVideoHandler = $deleteVideoHandler;
    }

    public function execute(): void
    {
        $videoId = Console::getArgument(2);

        $this->throwExceptionIfVideoIdIsNotSpecified($videoId);

        $command = new DeleteVideoCommand($videoId);

        $this->deleteVideoHandler->handle($command);

        Console::success('Видео успешно удалено');
    }

    private function throwExceptionIfVideoIdIsNotSpecified(string $videoId): void
    {
        if (empty($videoId)) {
            throw new InvalidArgumentException('Не указан id видео');
        }
    }

}