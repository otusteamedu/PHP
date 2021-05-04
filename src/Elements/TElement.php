<?php


namespace Src\Elements;


class TElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [false,true,false],
                [true,true,true]
            ],
            [
                [true,false],
                [true,true],
                [true,false],
            ],
            [
                [true,true,true],
                [false,true,false]
            ],
            [
                [false,true],
                [true,true],
                [false,true],
            ],
        ];
    }
}