<?php

declare(strict_types=1);

namespace App\Model\Video\UseCase\Delete;

class DeleteVideoCommand
{

    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

}