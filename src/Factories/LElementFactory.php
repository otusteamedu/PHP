<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\LElement;

class LElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new LElement();
    }
}