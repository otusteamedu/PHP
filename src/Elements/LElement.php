<?php


namespace Src\Elements;


class LElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [false,false,true],
                [true,true,true]
            ],
            [
                [true,false],
                [true,false],
                [true,true],
            ],
            [
                [true,true,true],
                [true,false,false]
            ],
            [
                [true,true],
                [false,true],
                [false,true],
            ],
        ];
    }
}