<?php


namespace Src\Elements;


abstract class BaseElement implements Element
{
    protected array $shapes;
    protected string $color;
    protected array $currentShape;
    protected int $placementRow = 0;
    protected int $placementCol = 0;
    protected int $speed = 1;

    public function __construct()
    {
        $this->makeShapes();
        $this->currentShape = current($this->shapes);
    }

    public function setColor(string $color) : void
    {
        $this->color = $color;
    }

    public function getColor() : string
    {
        return $this->color;
    }

    public function rotate() : array
    {
        if(current($this->shapes) === $this->shapes[count($this->shapes) - 1]){
            return reset($this->shapes);
        }

        return next($this->shapes);
    }

    public function getShapes(): array
    {
       return $this->shapes;
    }

    public function getCurrentShape(): array
    {
        return $this->currentShape;
    }

    public function setCurrentShape(array $shape): void
    {
        if(in_array($shape, $this->shapes, true)){
            throw new \RuntimeException('Invalid shape for element: ' . __CLASS__);
        }

        $this->currentShape = $shape;
    }

    public function setPlacementRow(int $value) : void
    {
        $this->placementRow = $value;
    }

    public function getPlacementRow() : int
    {
        return $this->placementRow;
    }

    public function setPlacementCol(int $value) : void
    {
        $this->placementCol = $value;
    }

    public function getPlacementCol() : int
    {
        return $this->placementCol;
    }

    public function setSpeed(int $value) : void
    {
        $this->speed = $value;
    }

    public function getSpeed() : int
    {
        return $this->speed;
    }

    abstract protected function makeShapes() : void;
}