<?php
declare(strict_types = 1);

namespace Alex\Deikstra;


class Dlist
{
    public $next;
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
}