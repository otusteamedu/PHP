<?php

namespace App\ModelHydrators;

interface ElasticHydratorInterface
{
    /**
     * @param array $modelRawData
     *
     * @return array
     */
    public function hydrate(array $modelRawData): array;
}
