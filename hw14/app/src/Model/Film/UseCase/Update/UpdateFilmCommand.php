<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Update;

class UpdateFilmCommand
{
    public string $id;
    public string $name;
    public int    $productionYear;
}