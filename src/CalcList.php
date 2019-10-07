<?php
declare(strict_types = 1);

namespace Alex\Deikstra;


class CalcList
{
    private $size = 0;
    private $liststart;

    public function __construct()
    {
    }

    public function add(array $x)
    {
        $this->size++;

        if($this->liststart == null) {
            $this->liststart = new Dlist($x);
        } else {
            $node = $this->liststart;
            $newNode = new Dlist($x);
            $lastNode = null;
            $added = false;
            while($node) {
                if ($this->compare($newNode, $node) < 0) {
                    $newNode->next = $node;
                    if ($lastNode == null) {
                        $this->liststart = $newNode;
                    } else {
                        $lastNode->next = $newNode;
                    }
                    $added = true;
                    break;
                }
                $lastNode = $node;
                $node = $node->next;
            }
            if (!$added) {
                $lastNode->next = $newNode;
            }
        }
    }


    public function getSize()
    {
        return $this->size;
    }

    public function peak()
    {
        return $this->liststart->data;
    }

    public function remove()
    {
        $x = $this->peak();
        $this->size = $this->size - 1;
        $this->liststart = $this->liststart->next;
        return $x;
    }

    private function compare($a, $b)
    {
        return $a->data[0] - $b->data[0];
    }
}