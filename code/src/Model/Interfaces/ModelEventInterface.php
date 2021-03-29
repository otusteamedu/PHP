<?php


namespace App\Model\Interfaces;


interface ModelEventInterface
{
    public function getId(): int;
    public function setId(int $id): void;
    public function getCondition(): array;
    public function setCondition(array $params): void;
    public function getEvent(): string;
    public function setEvent(string $event): void;
    public function getPriority(): int;
    public function setPriority(int $priority): void;
    public function toArray(): array;
}
