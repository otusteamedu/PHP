<?php


namespace App\Stories;


use App\Repository\EventCommandRepository;


class StoreEventStory implements Story
{
    private EventCommandRepository $commandRepository;

    public function __construct()
    {
        $this->commandRepository = new EventCommandRepository();
    }

    public function execute($data = null)
    {
        return $this->commandRepository->create($data);
    }
}