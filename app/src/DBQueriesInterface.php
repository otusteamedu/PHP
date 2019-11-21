<?php


namespace App;


interface DBQueriesInterface
{
    public function insert(string $table, array $fields);
    public function update(string $table, array $fields);
    public function delete(string $table);
    public function findByID(string $table);
    public function findAll(string $table);

}