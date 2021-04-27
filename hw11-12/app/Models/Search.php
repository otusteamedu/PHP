<?php

namespace App\Models;

use JetBrains\PhpStorm\ArrayShape;

class Search extends BaseModel
{
    public const INDEX = 'search';
    /**
     * @var string
     */
    private string $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return self::INDEX;
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['id' => "string"])]
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
        ];
    }
}
