<?php

declare(strict_types=1);

namespace App\Model\Event\Repository;

use App\Model\Event\Entity\Condition;
use App\Model\Event\Entity\Event;
use App\Model\Event\Entity\EventId;

interface EventRepositoryInterface
{

    public function getAll(): array;

    /**
     * @param int $limit
     * @param int $skip
     *
     * @return Event[]
     */
    public function get(int $limit, int $skip): array;

    public function getOne(EventId $id): Event;

    public function add(Event $event): void;

    public function delete(Event $event): void;

    public function deleteAll(): void;

    /**
     * @param Condition[] $conditions
     *
     * @return Event|null
     */
    public function findOneByConditions(array $conditions): ?Event;

}