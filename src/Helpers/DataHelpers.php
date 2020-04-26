<?php

namespace Bjlag\Helpers;

use Bjlag\Dto;
use InvalidArgumentException;

class DataHelpers
{
    /**
     * @param $dto
     * @param array $data
     * @param array $requiredFields
     *
     * @return \Bjlag\Dto
     */
    public static function fillDto(Dto $dto, array $data, array $requiredFields): Dto
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new InvalidArgumentException("Поле '{$field}' обязательно для заполнения.");
            }

            $setterName = strtr($field, ['_' => ' ']);
            $setterName = ucwords($setterName);
            $setterName = 'set' . strtr($setterName, [' ' => '']);

            $dto->{$setterName}($data[$field]);
        }

        return $dto;
    }
}
