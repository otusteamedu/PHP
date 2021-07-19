<?php

declare(strict_types=1);

namespace App\Model\Request\UseCase\Add;

class AddRequestCommand
{
    public string $id;
    public string $name;
}