<?php

namespace Filter;

use MongoDB\BSON\ObjectId;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class MongoFilter extends CommonFilter
{
    /**
     * @return array
     */
    public function fetch(): array
    {
        $row = [];
        try {
            $reflect = new ReflectionClass(static::class);
            $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
            foreach ($properties as $property) {
                $name = $property->getName();
                $value = $this->{$name};
                if (empty($value) XOR ($value === false)) continue;
                $row[$name]["\$in"] = is_array($value) ? $value : [$value];
            }
            if (array_key_exists("id", $row)) {
                $row["_id"] = [
                    "\$in" => array_map(function ($id) {
                        return new ObjectId($id);
                    }, $row["id"]["\$in"]),
                ];
                unset($row["id"]);
            }
        } catch (ReflectionException $e) {
        }
        return $row;
    }
}