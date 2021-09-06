<?php

namespace App\Services\Checkers;

abstract class AbstractChecker
{
    /**
     * @var array
     */
    protected array $info = ['status' => 'success'];

    /**
     * @var array
     */
    protected array $shortInfo = ['status' => 'success'];

    /**
     * Запускает проверку
     *
     * @return $this
     */
    abstract public function check(): self;

    /**
     * Возвращает результат проверки
     *
     * @return array
     */
    public function getInfo(): array
    {
        return $this->info;
    }

    /**
     * Возвращает короткую информацию по результатам проверки
     * @return array
     */
    public function getShortInfo(): array
    {
        return $this->shortInfo;
    }

}