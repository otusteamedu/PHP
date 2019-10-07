<?php
declare(strict_types = 1);

namespace Alex\Deikstra;


class Edge
{
    //name start
    public $start;
    //name end
    public $end;
    //edge weight - distance (as example)
    public $weight;

    public function __construct($start, $end, $weight)
    {
        $this->start = $start;
        $this->end = $end;
        $this->weight = $weight;
    }
}