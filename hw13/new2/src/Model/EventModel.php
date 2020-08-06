<?php


namespace AYakovlev\Model;


use AYakovlev\Core\RedisBD;
use AYakovlev\Model\MultitonTrait;

class EventModel extends RedisBD
{
    use MultitonTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function getBestEventByConditions(array $conditions): array
    {
        return parent::getBestEventByConditions($conditions);
    }
}