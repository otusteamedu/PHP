<?php

declare(strict_types=1);

namespace App\Model\Event\UseCase\Delete;

class DeleteEventCommand
{

    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

}