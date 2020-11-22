<?php

namespace eav;

class Attribute extends Model
{
    public $attr_id;
    public $attr_name;
    public $attr_type;
    public $attr_entity_id;
    public $table = 'attrs';

}