<?php


namespace Otus\Processes;


use Otus\Storage\StorageInterface;
use Otus\View;

class EventDeleter implements EventProcessInterface
{
    public function process(StorageInterface $storage)
    {
        $storage->delete();
        View::showMessage('all events have been deleted');
    }
}