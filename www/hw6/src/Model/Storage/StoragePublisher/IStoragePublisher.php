<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Storage\StoragePublisher;

use Nlazarev\Hw6\Model\Collection\CollectionObserver\ICollectionObserver;
use Nlazarev\Hw6\Model\Collection\CollectionPublisher\ICollectionPublisher;
use SplSubject;

interface IStoragePublisher
{
    public static function getInstance(): IStoragePublisher;
    public function attach(IPublisherWithEvents $publisher): void;
    public function getPublishers(): ICollectionPublisher;
    public function getObservers(SplSubject $publisher): ICollectionObserver;
    public function count($mode = COUNT_NORMAL): int;
}
