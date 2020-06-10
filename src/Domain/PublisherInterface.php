<?php

namespace App\Domain;

interface PublisherInterface
{
    /**
     * @param string $id
     * @param mixed  $data
     * @throws \InvalidArgumentException
     */
    public function publish(string $id, $data): void;
}
