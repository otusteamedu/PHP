<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Delete;

class DeleteFilmCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}