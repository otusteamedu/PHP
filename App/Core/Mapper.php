<?php
namespace Ozycast\App\Core;

abstract class Mapper
{
    /**
     * @var Db
     */
    protected $connect = null;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    /**
     * @param $params
     * @return DTO|null
     */
    public function findOne($params): ?DTO
    {
        $db = $this->connect->findOne($this->collectName, $params);
        $model = $db ? $this->getDTO()->serialize($db) : null;
        return $model;
    }
}