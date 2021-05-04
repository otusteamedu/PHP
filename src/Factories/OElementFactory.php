<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\OElement;

class OElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new OElement();
    }
}