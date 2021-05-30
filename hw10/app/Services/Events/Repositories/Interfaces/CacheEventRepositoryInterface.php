<?php


namespace App\Services\Events\Repositories\Interfaces;


interface CacheEventRepositoryInterface
{
    public function store(string $key, string $priority, string $event) :int;
    public function getOne(string $key) : ?string;
    public function flush() :bool;
}
