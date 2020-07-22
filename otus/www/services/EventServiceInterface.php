<?php


namespace Services;


use Classes\Dto\EventDto;

interface EventServiceInterface
{
    public function create(EventDto $eventDto);

    public function deleteAll();

    public function getPriority(EventDto $eventDto);
}
