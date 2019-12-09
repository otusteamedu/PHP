<?php

namespace App\Contracts;

use App\Entities\Event;

interface Storage
{
    /**
     * @param array $params
     * @return Event|null
     */
    public function find(array $params): ?Event;

    /**
     * @param Event $event
     * @return bool
     */
    public function insert(Event $event): bool;

    public function clear(): void;
}
