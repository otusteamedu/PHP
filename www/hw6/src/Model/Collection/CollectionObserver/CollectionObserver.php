<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionObserver;

use Nlazarev\Hw6\Model\Iterator\IIteratorCustom;
use Nlazarev\Hw6\Model\Iterator\IteratorObserver\IteratorObserverWithEvents;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\IPublisherWithEvents;
use SplObserver;

class CollectionObserver implements ICollectionObserver
{
    private array $observers;

    public function __construct(string ...$events)
    {
        foreach ($events as $event) {
            $this->initEventGroup($event);
        }
    }

    private function initEventGroup($event): void
    {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = [];
        }
    }

    public function getEvents(): array
    {
        return array_keys($this->observers);
    }

    public function add(SplObserver $observer, $event)
    {
        $this->initEventGroup($event);
        $this->observers[$event][] = $observer;

        return $this;
    }

    public function rem(SplObserver $observer, $event)
    {
        foreach ($this->getIterator($event) as $key => $value) {
            if ($value === $observer) {
                unset($this->observers[$event][$key]);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->observers;
    }

    public function getIterator($event = IPublisherWithEvents::EVENTS_ALL): IIteratorCustom
    {
        return new IteratorObserverWithEvents($this, $event);
    }
}
