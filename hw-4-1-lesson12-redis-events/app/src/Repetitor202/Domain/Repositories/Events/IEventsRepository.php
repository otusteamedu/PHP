<?php


namespace Repetitor202\Domain\Repositories\Events;


use Repetitor202\Domain\DTO\EventSearchDTO;
use Repetitor202\Domain\DTO\EventStoreDTO;

interface IEventsRepository
{
    public function search(EventSearchDTO $searchDto): ?string;

    public function insert(EventStoreDTO $storeDto): array;

    public function clean(): bool;
}