<?php


namespace App\Controllers;


use App\Dto\EventDto;
use App\Stories\DeleteEventStory;
use App\Stories\GetPriorityEventStory;
use App\Stories\StoreEventStory;

class MainController
{
    public function saveEvent($request, StoreEventStory $story)
    {
        $dto = new EventDto();
        $dto->setName($request['name']);
        $dto->setPriority($request['priority']);
        $dto->setConditions($request['conditions']);

        return $story->execute($dto);
    }

    public function deleteEvent($request, DeleteEventStory $story)
    {
        $dto = new EventDto();
        $dto->setName($request['name']);

        return $story->execute($dto);
    }

    public function getPriorityEvent($request, GetPriorityEventStory $story)
    {
        $dto = new EventDto();
        $dto->setConditions($request['conditions']);

        return $story->execute($request);
    }

}