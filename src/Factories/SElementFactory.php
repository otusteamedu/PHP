<?php


namespace Src\Factories;


use Src\Elements\Element;
use Src\Elements\SElement;

class SElementFactory implements ElementFactory
{
    public function makeElement() : Element
    {
        return new SElement();
    }
}