<?php

namespace Bjlag\Helpers;

use Bjlag\Forms;
use InvalidArgumentException;

class DataHelpers
{
    /**
     * @param $dto
     * @param array $data
     * @param array $requiredFields
     *
     * @return \Bjlag\Forms
     */
    public static function fillDto(Forms $dto, array $data, array $requiredFields): Forms
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
