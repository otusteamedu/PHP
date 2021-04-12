<?php

declare(strict_types=1);

namespace App\Model\Channel\Entity;

use InvalidArgumentException;

class Channel
{

    private string $id;
    private string $title;

    public function __construct(string $id, string $title)
    {
        $this->assertIdIsNotEmpty($id);
        $this->assertTitleIsNotEmpty($title);

        $this->id = $id;
        $this->title = $title;
    }

    private function assertIdIsNotEmpty(string $id): void
    {
        if (empty(trim($id))) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

    private function assertTitleIsNotEmpty(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Не указано название канала');
        }
    }

    public function changeTitle(string $title): void
    {
        $this->assertTitleIsNotEmpty($title);

        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
        ];
    }

}