<?php
// app/Support/CommandMap.php

namespace App\Support;

class CommandMap
{

    /**
     * Маппинг команд. Имя команды => Ключ в контейнере
     * @var string[]
     */
    private  $map = [];

    public function set(string $name, string $value)
    {
        $this->map[$name] = $value;
    }

    /**
     * @return string[]
     */
    public function getMap()
    {
        return $this->map;
    }
}