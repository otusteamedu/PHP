<?php

namespace Src\Database\Connectors;

interface IConnector
{
    /**
     * Устанавливает соединение с базой данных
     *
     * @return mixed
     */
    public function connect(): mixed;
}