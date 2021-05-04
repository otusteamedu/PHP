<?php


namespace Src\Entities;


use Src\Iterators\PlayGroundCellsIterator;
use Src\Iterators\PlayGroundFromDownToUpIterator;

class PlayGround
{
    private int $rows;
    private int $cols;

    public function __construct(int $rows, int $cols)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->fill();
    }

    /**
     * @var array | PlayGroundCell[]
     */
    private array $cells;

    /**
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * @param int $rows
     */
    public function setRows(int $rows): void
    {
        $this->rows = $rows;
    }

    /**
     * @return int
     */
    public function getCols(): int
    {
        return $this->cols;
    }

    /**
     * @param int $cols
     */
    public function setCols(int $cols): void
    {
        $this->cols = $cols;
    }

    /**
     * @return array|PlayGroundCell[]
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @param array|PlayGroundCell[] $cells
     */
    public function setCells(array $cells): void
    {
        $this->cells = $cells;
    }

    public function getFromDownToUpIterator(int $fromRow, int $countRows = 1) : PlayGroundCellsIterator
    {
        return new PlayGroundFromDownToUpIterator($this, $fromRow, $countRows);
    }

    private function fill() : void
    {
        for($r = 0; $r < $this->rows; $r++){
            for($c = 0; $c < $this->cols; $c++){
                $cell = new PlayGroundCell();
                $cell->setRow($r);
                $cell->setColumn($c);
                $this->cells[] = $cell;
            }
        }
    }

}