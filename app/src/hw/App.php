<?php

namespace Otus;

use Otus\Processes\EventProcessFactory;
use Otus\Storage\StorageFactory;
use Otus\Storage\StorageInterface;
use Otus\Validators\RequestValidator;

class App
{
    private StorageInterface $storage;
    private array $data;

    public function __construct()
    {
        $validator = new RequestValidator();
        $validator->validate();
        $this->data = $validator->getValidatedData();

        $this->storage = $this->getStorage();
    }

    public function run()
    {
        $event = EventProcessFactory::getProcess($this->data);
        $event->process($this->storage);
    }

    private function getStorage(): StorageInterface
    {
        return StorageFactory::create();
    }
}
