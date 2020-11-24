<?php

namespace app\storage;

use app\events\IEvent;

interface IEventStorage
{
    public function save(IEvent $event);
    public function fetchAll();
    public function clear();
}