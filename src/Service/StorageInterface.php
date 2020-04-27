<?php


namespace Service;


interface StorageInterface
{
    public function insertOne(object $object);

    public function findOne(string $id);

    public function find(array $filter);

    public function deleteOne(string $id);

    public function getSummary(string $channelId);

    public function getTopChannels(int $limit);

}