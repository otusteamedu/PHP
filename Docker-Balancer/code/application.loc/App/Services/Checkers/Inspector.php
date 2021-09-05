<?php

namespace App\Services\Checkers;


use App\Exceptions\Checkers\InvalidCheckerException;


class Inspector
{
    /**
     * Создает Checkers и выполняет проверку
     *
     * @param string $checker - имя класс Checkers-а
     * @param $config - Параметры для Чекера 
     * @return AbstractChecker
     * @throws InvalidCheckerException
     */
    public static function check(string $checker, $config): AbstractChecker
    {
        return CheckersFactory::make($checker, $config)->check();
    }

}