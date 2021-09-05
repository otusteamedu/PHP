<?php

namespace App\Services\Checkers;

use App\Helpers\AppConst;

/**
 * Checker-ошибка. Подставляется, когда чекер вываливается по exception
 */
class ErrorChecker extends AbstractChecker
{
    /**
     * Конструктор класса
     *
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message)
    {
        $this->info = ['status' => AppConst::ERROR_CONNECTED, 'error' => ['code' => $code, 'message' => $message]];
        $this->shortInfo = ['status' => AppConst::ERROR_CONNECTED, 'error' => ['code' => $code, 'message' => $message]];
    }

    /**
     * Возвращает себя
     */
    public function check(): self
    {
        return $this;
    }
}