<?php

namespace Src\Factories;

use Src\Elements\Element;

interface ElementFactory
{
    public function makeElement() : Element;
}