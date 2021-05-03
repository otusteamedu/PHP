<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\TElement;

class TElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new TElement();
    }
}