<?php

declare(strict_types=1);

namespace App\Model\Request\UseCase\Handle;

class HandleRequestCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
