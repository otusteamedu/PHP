<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\ZElement;

class ZElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new ZElement();
    }
}