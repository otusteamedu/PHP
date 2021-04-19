<?php

namespace App\ModelHydrators;

use App\Models\BaseModel;

abstract class AbstractElasticHydrator implements ElasticHydratorInterface
{
    /**
     * @param array $modelRawData
     *
     * @return BaseModel[]
     */
    public function hydrate(array $modelRawData): array
    {
        $models = [];
        $modelName = static::MODEL;
        $model = new $modelName();

        foreach (static::MAPPING as $key => $currentMappedProperty) {
            call_user_func([$model, $key], $modelRawData['_source'][$currentMappedProperty] ?? null);
        }

        $models[] = $model;

        return $models;
    }
}
