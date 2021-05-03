<?php


namespace Src\Elements;


interface Element
{
    public function setColor(string $color) : void;

    public function getColor() : string;

    public function rotate() : array;

    public function getShapes() : array;

    public function getCurrentShape() : array;

    public function setCurrentShape(array $shape) : void;

    public function setPlacementRow(int $value) : void;

    public function getPlacementRow() : int;

    public function setPlacementCol(int $value) : void;

    public function getPlacementCol() : int;

    public function setSpeed(int $value) : void;

    public function getSpeed() : int;
}