<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Iterator\IteratorObserver;

use Nlazarev\Hw6\Model\Collection\CollectionObserver\ICollectionObserver;
use Nlazarev\Hw6\Model\Iterator\IIteratorCustom;
use Nlazarev\Hw6\Model\Iterator\IteratorCustom;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\IPublisherWithEvents;
use SplObserver;

class IteratorObserverWithEvents extends IteratorCustom implements IIteratorCustom
{
    private $observers = [];

    public function __construct(ICollectionObserver $observers, $event = IPublisherWithEvents::EVENTS_ALL)
    {
        $this->observers = $observers->toArray()[$event];
    }

    public function current(): SplObserver
    {
        return $this->observers[$this->key()];
    }

    public function valid(): bool
    {
        return isset($this->observers[$this->key()]);
    }
}
