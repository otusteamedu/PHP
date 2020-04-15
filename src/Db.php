<?php

namespace App;

use Traversable;

interface Db
{
    public function save(object $data, string $type): void;

    public function addIndex(string $collection, string $key, array $options = []): void;

    public function getTopChannels(int $limit): Traversable;

    public function getChannelLikes(string $id): Traversable;
}
