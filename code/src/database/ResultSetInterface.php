<?php

namespace crazydope\theater\database;

interface ResultSetInterface extends \Countable
{
    public function initialize($dataSource);

    public function getFieldCount();
}