<?php


namespace App\Services\Interfaces;


use App\Model\Interfaces\EventInterface;

interface EventServiceInterface
{
    public function addEvent(int $priority, array $params, string $event): EventInterface;
    public function getEvent(array $params): EventInterface;
    public function getAll(): array;
    public function deleteEvents(): bool;
}
