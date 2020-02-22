<?php

namespace Tirei01\Hw12\Storage;

use Tirei01\Hw12\DomainObject;

class Value extends DomainObject
{
    private Element $element;

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
    private Property $property;
    private Category $category;
    private ?int $numericValue = null;
    private ?string $stringValue = null;
    /**
     * @return int
     */
    public function getNumericValue(): ?int
    {
        return $this->numericValue;
    }

    /**
     * @param int $numericValue
     */
    public function setNumericValue(?int $numericValue): void
    {
        $this->numericValue = $numericValue;
    }

    /**
     * @return string
     */
    public function getStringValue(): ?string
    {
        return $this->stringValue;
    }

    /**
     * @param string $stringValue
     */
    public function setStringValue(?string $stringValue): void
    {
        $this->stringValue = $stringValue;
    }

    public function __construct(
        int $id,
        Property $property,
        Element $element,
        $numericValue,
        $stringValue,
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
        $this->setNumericValue(intval($numericValue));
        $this->setStringValue(strval($stringValue));
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