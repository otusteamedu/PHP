<?php

declare(strict_types=1);

namespace App\DataBase;

interface ClientCreatorInterface
{
    public static function create(array $config): object;
}