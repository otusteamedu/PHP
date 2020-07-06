<?php

namespace App\Stories;

use App\Repository\EventQueryRepository;

class GetPriorityEventStory implements Story
{
    private EventQueryRepository $queryRepository;

    public function __construct()
    {
        $this->queryRepository = new EventQueryRepository();
    }

    public function execute($data = null)
    {
        return $this->queryRepository->getPriorityEvent($data);
    }
}
