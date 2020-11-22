<?php

namespace eav;

class Value extends Model
{
    public $av_id;
    public $av_film_id;
    public $av_entity_id;
    public $av_attribute_id;
    public $av_attr_value;

    public $table = '';
    /**
     * @var Attribute
     */
    private $attr;

    public function __set($name, $value)
    {

        switch ($name) {
            case 'av_attribute_id':
                $this->attr = (new Attribute())->findByAttr(['attr_id'=>$value]);
                break;
            case 'av_attr_value':
                if (get_class($value) !== $this->attr->attr_type) {
                    new \Exception('Incompatible value type');
                    return false;
                }
                $this->av_attr_value = $value;
                break;
            default:
                break;
        }
        $this->$name = $value;
    }
}