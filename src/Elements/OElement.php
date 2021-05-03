<?php


namespace Src\Elements;


class OElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [true,true],
                [true,true]
            ]
        ];
    }
}