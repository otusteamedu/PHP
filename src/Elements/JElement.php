<?php


namespace Src\Elements;


class JElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [true,false,false],
                [true,true,true]
            ],
            [
                [true,true],
                [true,false],
                [true,false],
            ],
            [
                [true,true,true],
                [false,false,true]
            ],
            [
                [false,true],
                [false,true],
                [true,true],
            ],
        ];
    }
}