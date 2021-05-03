<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\IElement;

class IElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new IElement();
    }
}