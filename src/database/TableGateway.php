<?php

namespace crazydope\theater\database;

use crazydope\theater\database\adapter\PdoAdapterInterface;

class TableGateway extends AbstractTableGateway
{
    /**
     * TableGateway constructor.
     * @param string $table
     * @param PdoAdapterInterface $adapter
     * @param null $resultSet
     */
    public function __construct(string $table, PdoAdapterInterface $adapter, $resultSet = null)
    {
        $this->table = $table;
        $this->adapter = $adapter;
        $this->resultSetPrototype = $resultSet;

        $this->initialize();
    }
}