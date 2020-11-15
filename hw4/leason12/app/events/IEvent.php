<?php

namespace app\events;

interface IEvent
{
    public function add(int $priority, array $conditions);
    public function clear();
    public function fetchBest(array $params);
}