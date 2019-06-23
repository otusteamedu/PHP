<?php

namespace crazydope\events;

interface EventInterface
{
    public static function jsonDeserialize($json): EventInterface;

    public function getId(): ?int;

    public function setId(int $id): EventInterface;

    public function getName(): string;

    public function setName(string $name): EventInterface;

    public function getDescription(): string;

    public function setDescription(string $description): EventInterface;

    public function toArray(): array;
}