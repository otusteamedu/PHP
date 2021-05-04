<?php


namespace Src\Subscribers;


use Src\Events\Event;

class ClearPlayGround implements Subscriber
{
    public function handle(Event $event): void
    {
        $play = $event->getPlay();
        $resetRowsDto = $event->getResetRowsDto();

        $resetRowsIterator = $play->getPlayGround()->getFromDownToUpIterator(
            $resetRowsDto->getFrom(),
            $resetRowsDto->getCount()
        );

        while($resetRowsIterator->hasMore()){
            $cell = $resetRowsIterator->next();
            $cell->setColor('');
            $cell->setValue(false);
        }

        $movedRowsIterator = $play->getPlayGround()->getFromDownToUpIterator(
            $resetRowsDto->getCount() + $resetRowsDto->getCount() +1,
            $play->getPlayGround()->getRows()
        );

        while($movedRowsIterator->hasMore()){
            $cell = $movedRowsIterator->next();
            $cell->setRow($resetRowsDto->getCount());
        }

    }
}