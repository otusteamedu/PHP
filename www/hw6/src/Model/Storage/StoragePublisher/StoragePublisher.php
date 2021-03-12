<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Storage\StoragePublisher;

use Nlazarev\Hw6\Model\Collection\CollectionObserver\ICollectionObserver;
use Nlazarev\Hw6\Model\Collection\CollectionPublisher\CollectionPublisher;
use Nlazarev\Hw6\Model\Collection\CollectionPublisher\ICollectionPublisher;
use SplObjectStorage;
use SplSubject;

class StoragePublisher implements IStoragePublisher
{
    private static StoragePublisher $instance;
    private SplObjectStorage $storage;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): StoragePublisher
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
            self::$instance->storage = new SplObjectStorage();
        }

        return self::$instance;
    }

    public function attach(IPublisherWithEvents $publisher): void
    {
        self::$instance->storage->attach($publisher, $publisher->getObservers());
    }

    public function getPublishers(): ICollectionPublisher
    {
        $publishers = new CollectionPublisher();

        foreach (self::$instance->storage as $key) {
            $publishers->add($key);
        }

        return $publishers;
    }

    public function getObservers(SplSubject $publisher): ICollectionObserver
    {
        return self::$instance->storage->offsetGet($publisher);
    }

    public function count($mode = COUNT_NORMAL): int
    {
        return self::$instance->storage->count($mode);
    }
}
