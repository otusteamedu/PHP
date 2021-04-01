<?php

namespace App\Repositories\Event;

use App\Entities\Event;
use Illuminate\Support\Collection;

interface EventRepository
{
    /**
     * @return Collection|Event[]
     */
    public function getAll() : Collection;

    /**
     * @param string $id
     * @return Event
     */
    public function getById(string $id) : Event;

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Event[]
     */
    public function search(string $string, int $offset = 0, int $limit = 100) : Collection;

    /**
     * @param Event $event
     * @return Event
     */
    public function save(Event $event) : Event;


    public function flushAll() : int;
}