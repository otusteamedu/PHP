<?php


namespace Src\Iterators;


use Src\Entities\PlayGround;
use Src\Entities\PlayGroundCell;

class PlayGroundFromDownToUpIterator implements PlayGroundCellsIterator
{
    private PlayGround $playGround;

    private int $currentKey = 0;
    private array $cells;

    public function __construct(PlayGround $playGround, int $fromRow, int $countRows)
    {
        $this->playGround = $playGround;
        $this->cells = $this->getCells($fromRow, $countRows);
    }

    public function hasMore(): bool
    {
        return isset($this->cells[$this->currentKey]);
    }

    public function next(): PlayGroundCell
    {
        if(false === $this->hasMore()){
            throw new \RuntimeException('No more cells');
        }

        $cell = $this->cells[$this->currentKey];
        $this->currentKey++;

        return $cell;
    }

    private function getCells(int $fromRow, int $countRows) : array
    {
        $result = [];
        foreach($this->playGround->getCells() as $cell){
            if($cell->getRow() >= $fromRow && $cell->getRow() <= $fromRow + $countRows){
                $result[] = $cell;
            }
        }

        return $result;
    }
}