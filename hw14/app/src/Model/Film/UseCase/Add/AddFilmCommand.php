<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Add;

class AddFilmCommand
{
    public string $name;
    public int    $productionYear;
}