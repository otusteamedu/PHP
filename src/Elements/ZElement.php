<?php


namespace Src\Elements;


class ZElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [true,true,false],
                [false,true,true]
            ],
            [
                [false,true],
                [true,true],
                [true,false],
            ],
        ];
    }
}