<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Storage\StoragePublisher;

use Nlazarev\Hw6\Model\Collection\CollectionObserver\ICollectionObserver;
use SplSubject;

interface IPublisherWithEvents extends SplSubject
{
    public const EVENTS_ALL = "*";
    public function getObservers(): ICollectionObserver;
}
