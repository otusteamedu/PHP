<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionObserver;

use IteratorAggregate;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\IObserverGroupWithEvents;
use SplObserver;

interface ICollectionObserver extends IObserverGroupWithEvents, IteratorAggregate
{
    public function add(SplObserver $observer, $event);
    public function rem(SplObserver $observer, $event);
    public function toArray(): array;
}
