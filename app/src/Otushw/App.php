<?php


namespace Otushw;

use Otushw\Request\Request;
use Otushw\Request\RequestFactory;
use Otushw\Storage\StorageFactory;
use Otushw\Storage\StorageInterface;
use Otushw\Params;

class App
{
    private StorageInterface $storage;
    private Request $requst;
    private string $status;

    public function __construct()
    {
       $this->storage = $this->getStorage();
       $this->requst = $this->getRequest();
    }

    public function run(): void
    {
        $this->requst->process($this->storage);
        $this->requst->showResult();
    }

    private function getStorage(): StorageInterface
    {
        return StorageFactory::create();
    }

    private function getRequest(): Request
    {
        $requst = new RequestFactory();
        return $requst->create();
    }
}