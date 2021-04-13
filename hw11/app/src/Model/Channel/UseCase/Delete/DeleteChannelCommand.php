<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Delete;

class DeleteChannelCommand
{

    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

}