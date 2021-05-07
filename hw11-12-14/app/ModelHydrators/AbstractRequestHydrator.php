<?php

namespace App\ModelHydrators;

use App\Models\BaseModel;

abstract class AbstractRequestHydrator implements RequestHydratorInterface
{
    /**
     * @param array $modelRawData
     *
     * @return BaseModel[]
     */
    public function hydrate(array $modelRawData): array
    {
        $models = [];

        foreach (static::MAPPING as $key => $currentMappedProperty) {
            call_user_func([$this->model, $key], $modelRawData[$currentMappedProperty] ?? null);
        }

        $models[] = $this->model;

        return $models;
    }
}
