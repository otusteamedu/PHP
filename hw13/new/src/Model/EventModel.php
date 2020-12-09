<?php


namespace AYakovlev\Model;


use AYakovlev\Core\RedisBD;

class EventModel extends RedisBD
{
    public function getBestEventByConditions(array $conditions): array
    {
        return parent::getBestEventByConditions($conditions);
    }


}