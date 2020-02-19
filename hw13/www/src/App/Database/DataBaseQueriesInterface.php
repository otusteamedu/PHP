<?php


namespace App\Database;


interface DataBaseQueriesInterface
{
    public function findById(string $table);
    public function findAll(string $table);
    public function findBy(string $table, string $fieldName);
    public function insert(string $table, array $fields);
    public function update(string $table, array $fields);
    public function delete(string $table);
}