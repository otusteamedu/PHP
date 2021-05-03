<?php

namespace Src\Services\Element;

use Src\Elements\Element;
use Src\Factories\ElementFactory;

class NextElementService
{
    public function get() : Element
    {
        $factory = $this->getFactory();
        $nextElement = $factory->makeElement();

        $nextElement->setColor($this->getColor());

        $nextElement->setCurrentShape($this->getShape($nextElement->getShapes()));

        return $nextElement;
    }

    private function getFactory() : ElementFactory
    {
        $nextFactoryClass = ELEMENT_FACTORIES[array_rand(ELEMENT_FACTORIES)];

        return new $nextFactoryClass;
    }

    private function getColor() : string
    {
        return ELEMENT_COLORS[array_rand(ELEMENT_COLORS)];
    }

    private function getShape(array $shapes) : array
    {
        return $shapes[array_rand($shapes)];
    }
}