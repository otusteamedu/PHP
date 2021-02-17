<?php

namespace Otus;

use Otus\Processes\EventProcessFactory;
use Otus\Storage\StorageFactory;
use Otus\Storage\StorageInterface;

class App
{
    private StorageInterface $storage;

    public function __construct()
    {
        $this->storage = $this->getStorage();
    }

    public function run()
    {
        $event = EventProcessFactory::getProcess();
        $event->process($this->storage);
    }

    private function getStorage(): StorageInterface
    {
        return StorageFactory::create();
    }
}
