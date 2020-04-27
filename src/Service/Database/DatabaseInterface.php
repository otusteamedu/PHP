<?php


namespace Service\Database;


interface DatabaseInterface
{
    public function setCollectionName(string $collectionName);

    public function getCollection();

}