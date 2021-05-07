<?php

namespace App\ModelHydrators;

interface RequestHydratorInterface
{
    /**
     * @param array $modelRawData
     *
     * @return array
     */
    public function hydrate(array $modelRawData): array;
}
