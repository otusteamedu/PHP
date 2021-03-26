<?php


namespace Otushw\Models;

class Query
{
    const STATUS_BEGIN = 'open';
    const STATUS_END = 'completed';

    private int $id;
    private string $status;

    public function __construct(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}