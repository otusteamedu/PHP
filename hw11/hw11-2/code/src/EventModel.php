<?php


namespace RedisApp;


class EventModel extends RedisBD
{
    public function getBestEventByConditions(array $conditions): array
    {
        return parent::getBestEventByConditions($conditions);
    }
}