<?php


namespace App\Services\Events\Repositories;


use App\Models\Event;

interface iEventRepository
{

    /**
     * Add event
     * @param $data
     */
    public function add($data): void;

    /**
     * Delete one event
     * @param string $name
     */
    public function delete(string $name): void;

    /**
     * Clear all events
     */
    public function clear(): void;
}
