<?php


namespace Classes\Repositories;


use Classes\Models\Event;

interface EventRepositoryInterface
{
    public function create(Event $event);

    public function deleteAll();

    public function getAllKeys();

    public function getKeyData(string $key);
}
