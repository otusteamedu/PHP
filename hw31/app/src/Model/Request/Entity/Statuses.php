<?php

declare(strict_types=1);

namespace App\Model\Request\Entity;

class Statuses
{
    public const NOT_HANDLED = 0;
    public const HANDLED     = 1;

    public static function get(): array
    {
        return [
            self::NOT_HANDLED => 'Не обработан',
            self::HANDLED     => 'Обработан!',
        ];
    }

    public static function getName(int $id): string
    {
        $statuses = static::get();

        return ($statuses[$id] ?? '');
    }
}