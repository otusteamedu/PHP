<?php


namespace App\Services\Orm\Interfaces;


interface OrmModelInterface
{
    public function getId(): ?int;
    public function setId(int $id): self;
    public function toArray(): array;
}
