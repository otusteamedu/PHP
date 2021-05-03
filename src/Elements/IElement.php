<?php


namespace Src\Elements;


class IElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [true],
                [true],
                [true],
                [true],
            ],
            [
                [true,true,true,true],
            ],
        ];
    }
}