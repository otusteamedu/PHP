<?php


namespace Otushw;

class App
{
    private StorageInterface $storage;
    private Params $param;

    public function __construct()
    {
        $this->getStorage();
        $this->getParam();
    }

    public function run()
    {
        $this->create();
    }

    private function create()
    {
        if ($this->param->isGrabber()) {
            return new Grabber($this->storage);
        }
        if ($this->param->isStats()) {
            return new Stats($this->storage);
        }
    }

    private function getStorage()
    {
        $this->storage = Storage::getStorage();
    }

    private function getParam()
    {
        $this->param = new Params();
    }


}