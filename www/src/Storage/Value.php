<?php

namespace Tirei01\Hw12\Storage;

use Tirei01\Hw12\DomainObject;

class Value extends DomainObject
{
    private Element $element;
    private Property $property;
    private Category $category;
    private $value = null;

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return Element
     */
    public function getElement(): Element
    {
        return $this->element;
    }

    /**
     * @param Element $element
     */
    public function setElement(Element $element): void
    {
        $this->element = $element;
    }

    public function __construct(
        int $id,
        Property $property,
        Element $element,
        $value = null,
        Category $category = null
    ) {
        $this->setId($id);
        $this->setProperty($property);
        $this->setElement($element);
        if($category === null){
            $this->setCategory($property->getCategory());
        }else{
            $this->setCategory($category);
        }
        $this->setValue($value);
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