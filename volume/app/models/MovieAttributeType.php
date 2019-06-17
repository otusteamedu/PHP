<?php

namespace  hw13\models;

use ActiveRecord\Model as ActiveRecord;

class MovieAttributeType extends ActiveRecord
{
    const INTEGER = 1;
    const TIMESTAMP = 2;
    const TEXT = 3;
    const BOOLEAN = 4;

    const ALL_TYPES = [
        MovieAttributeType::INTEGER => 'integer',
        MovieAttributeType::TIMESTAMP => 'timestamp',
        MovieAttributeType::TEXT => 'text',
        MovieAttributeType::BOOLEAN => 'boolean',
    ];

    static $table_name = "movie_attribute_type";
}
