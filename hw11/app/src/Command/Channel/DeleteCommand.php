<?php

declare(strict_types=1);

namespace App\Command\Channel;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Channel\UseCase\Delete\DeleteChannelCommand;
use App\Model\Channel\UseCase\Delete\DeleteChannelHandler;
use InvalidArgumentException;

class DeleteCommand implements CommandInterface
{

    private DeleteChannelHandler $deleteChannelHandler;

    public function __construct(DeleteChannelHandler $deleteChannelHandler)
    {
        $this->deleteChannelHandler = $deleteChannelHandler;
    }

    public function execute(): void
    {
        $channelId = Console::getArgument(2);

        $this->throwExceptionIfChannelIdIsNotSpecified($channelId);

        $command = new DeleteChannelCommand($channelId);
        $this->deleteChannelHandler->handle($command);

        Console::success('Канал успешно удален');
    }

    private function throwExceptionIfChannelIdIsNotSpecified(string $channelId): void
    {
        if (empty($channelId)) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

}