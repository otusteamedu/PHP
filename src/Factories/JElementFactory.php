<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\JElement;

class JElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new JElement();
    }
}