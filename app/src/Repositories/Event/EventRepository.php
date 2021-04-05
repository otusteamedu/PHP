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
     * @param int $id
     * @return Event
     */
    public function getById(int $id) : Event;

    public function delete(int $id) : int;

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Event[]
     */
    public function search(string $string, int $offset = 0, int $limit = 100) : Collection;

    /**
     * @param array $params
     * @param int $offset
     * @param int $limit
     * @return Collection|Event[]
     */
    public function searchByParams(array $params, int $offset = 0, int $limit = 100) : Collection;

    /**
     * @param array $params
     * @param int $offset
     * @param int $limit
     * @return Collection|Event[]
     */
    public function getAppropriateEventsByParams(array $params, int $offset = 0, int $limit = 1) : Collection;

    /**
     * @param Event $event
     * @return Event
     */
    public function save(Event $event) : Event;


    public function flushAll() : int;
}