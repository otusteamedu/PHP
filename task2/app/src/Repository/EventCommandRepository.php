<?php


namespace App\Repository;


use App\Database\RedisManager;
use App\Dto\EventDto;

class EventCommandRepository extends RedisManager
{
    public function create(EventDto $dto)
    {
        return $this->conn->hMSet(
            $dto->getName(),
            [
                'name' => $dto->getName(),
                'priority' => $dto->getPriority(),
                'conditions' => json_encode($dto->getConditions())
            ]
        );
    }

    public function flushAll() {
        return $this->conn->flushAll();
    }
}