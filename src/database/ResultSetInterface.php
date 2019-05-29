<?php

namespace crazydope\theater\database;

use Countable;

interface ResultSetInterface extends Countable
{
    public function initialize($dataSource);

    public function getFieldCount();
}