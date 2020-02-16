<?php

namespace Tirei01\Hw12\Storage;

use Tirei01\Hw12\DomainObject;

class Value extends DomainObject
{
    private Property $property;
    private Category $category;
    private $value;
    public function __construct(
        int $id,
        Property $property,
        $value,
        Category $category = null
    ) {
        $this->setId($id);
        $this->setProperty($property);
        if($category === null){
            $this->setCategory($property->getCategory());
        }else{
            $this->setCategory($category->getCategory());
        }
        // TODO DEL THIS
        echo "<pre style='color:red; clear: both;'>";
        var_dump($property->getType());
        echo "</pre>";
        if($property->getType() === 'int'){
            $this->setValue(intval($value));
        }else{
            $this->setValue(strval($value));
        }
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param Property $property
     */
    public function setProperty(Property $property): void
    {
        $this->property = $property;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}