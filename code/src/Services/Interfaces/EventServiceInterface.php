<?php


namespace App\Services\Interfaces;


use App\Model\Interfaces\ModelEventInterface;

interface EventServiceInterface
{
    public function addEvent(int $priority, array $params, string $event): ModelEventInterface;
    public function getEvent(array $params): ModelEventInterface;
    public function getAll(): array;
    public function deleteEvents(): bool;
}
