<?php

namespace App\ModelHydrators;

interface RedisHydratorInterface
{
    /**
     * @param array $modelRawData
     *
     * @return array
     */
    public function hydrate(array $modelRawData): array;
}
