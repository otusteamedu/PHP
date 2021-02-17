<?php


namespace Otus\Processes;


use Otus\DTO\EventDTO;
use Otus\Storage\StorageInterface;
use Otus\View;

class EventCreator implements EventProcessInterface
{
    private EventDTO $event;

    public function __construct(array $data)
    {
        $this->createEvent($data);
    }

    public function process(StorageInterface $storage)
    {
        $storage->save($this->event);
        View::showMessage("event was added");
    }

    private function createEvent($data)
    {
        $event = new EventDTO();
        $event->setId(time());
        $event->setEvent($data['event']);
        $event->setConditions($data['conditions']);
        $event->setPriority($data['priority']);

        $this->event = $event;
    }
}