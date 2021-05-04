<?php


namespace Src\Elements;


class SElement extends BaseElement
{
    public function makeShapes(): void
    {
        $this->shapes = [
            [
                [false,true,true],
                [true,true,false]
            ],
            [
                [true,false],
                [true,true],
                [false,true],
            ],
        ];
    }
}