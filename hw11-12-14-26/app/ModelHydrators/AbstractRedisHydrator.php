<?php

namespace App\ModelHydrators;

use App\Models\BaseModel;

abstract class AbstractRedisHydrator implements RedisHydratorInterface
{
    /**
     * @param array $modelsRawData
     *
     * @return BaseModel[]
     */
    public function hydrate(array $modelsRawData): array
    {
        $models = [];
        foreach ($modelsRawData as $serializedModel) {
            $models[] = unserialize($serializedModel);
        }

        return $models;
    }
}
