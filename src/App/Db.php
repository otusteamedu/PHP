<?php
namespace Ozycast\App;

interface Db
{
    public function connect();

    public function insert($collection, $data);
    public function update($collection, $filter, $data);

    public function findAll($collection, $params);
    public function findOne($collection, $params);
}