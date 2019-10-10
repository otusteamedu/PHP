<?php

namespace TimGa\hw26\model;

use \TimGa\hw26\db\MysqlDb;

class AbstractModel
{

    protected $mysqlDb;

    public function __construct()
    {
        $this->mysqlDb = new MysqlDb;
    }

}
