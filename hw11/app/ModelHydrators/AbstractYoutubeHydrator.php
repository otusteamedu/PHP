<?php

namespace App\ModelHydrators;

use stdClass;
use JetBrains\PhpStorm\ArrayShape;
use App\Exceptions\WrongModelPropertyMappingException;

abstract class AbstractYoutubeHydrator implements YoutubeHydratorInterface
{
    /**
     * @param stdClass $modelRawData
     *
     * @return array
     *
     * @throws WrongModelPropertyMappingException
     */
    #[ArrayShape(['nextPageToken' => "mixed", 'models' => "array"])]
    public function hydrate(stdClass $modelRawData): array
    {
        $nextPageToken = $modelRawData->nextPageToken ?? null;
        $models = [];

        foreach ($modelRawData->items as $modelRawEntry) {
            $modelName = static::MODEL;
            $model = new $modelName();

            foreach (static::MAPPING as $key => $currentMappedProperty) {
                //call corresponding setter of the model and set a value to a given property
                call_user_func([$model, $key], $this->getNestedProperty($currentMappedProperty, $modelRawEntry));
            }

            $models[] = $model;
        }

        return ['nextPageToken' => $nextPageToken, 'models' => $models];
    }

    /**
     * @param string $mappedProperty
     * @param stdClass $object
     *
     * @return string|null
     *
     * @throws WrongModelPropertyMappingException
     */
    private function getNestedProperty(string $mappedProperty, stdClass $object): ?string
    {
        foreach (explode('.', $mappedProperty) as $value) {
            if (!is_a($object, stdClass::class)) {
                throw new WrongModelPropertyMappingException(static::MODEL);
            }

            if (!isset($object->{$value})) {
                return null;
            }

            $object = $object?->{$value};
        }

        return $object;
    }
}
