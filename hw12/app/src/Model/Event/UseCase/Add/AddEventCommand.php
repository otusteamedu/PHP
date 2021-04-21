<?php

declare(strict_types=1);

namespace App\Model\Event\UseCase\Add;

class AddEventCommand
{

    public string $name;
    public int    $priority;
    public array  $conditions = [];

}