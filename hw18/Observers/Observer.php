<?php
declare(strict_types=1);

namespace DesignPatterns\Observers;

interface Observer
{
    /**
     * @param string $eventName
     *
     * @return void
     */
    public function update(string $eventName): void;
}
