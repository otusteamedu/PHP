<?php
namespace Ozycast\App\Core;

interface Cache
{
    public function connect(): Cache;

    /**
     * @return bool
     */
    public function clear(): bool;
}