<?php

namespace Ozycast\App\Models;

class OrderStatus
{
    public static function getStatus(int $id): string
    {
        $status = self::status();

        if (!isset($status[$id]))
            return null;

        return $status[$id];
    }

    public static function status()
    {
        return [
            "Отменен",
            "Создан",
            "Обработан"
        ];
    }
}