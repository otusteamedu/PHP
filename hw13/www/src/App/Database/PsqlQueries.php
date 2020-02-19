<?php


namespace App\Database;

class PsqlQueries implements DataBaseQueriesInterface
{
    /**
     * @param string $table
     * @return string
     */
    public function findById(string $table): string
    {
        $query =  "select * from %s where id = ?";
        return sprintf($query, $table);
    }

    /**
     * @param string $table
     * @return string
     */
    public function findAll(string $table): string
    {
        $query =  "select * from %s";
        return sprintf($query, $table);
    }

    /**
     * @param string $table
     * @param string $fieldName
     * @return string
     */
    public function findBy(string $table, string $fieldName): string
    {
        $query =  "select * from %s where %s = ?";
        return sprintf($query, $table, $fieldName);
    }

    /**
     * @param string $table
     * @param array $fields
     * @return string
     */
    public function insert(string $table, array $fields): string
    {
        $query =  "insert into %s (%s) values (%s)";
        return sprintf($query, $table, implode(', ', $fields), rtrim(str_repeat('?, ', count($fields)), ', '));
    }

    /**
     * @param string $table
     * @param array $fields
     * @return string
     */
    public function update(string $table, array $fields): string
    {
        $query =  "update %s set %s=? where id = ?";
        return sprintf($query, $table, implode('=?, ', $fields));
    }

    /**
     * @param string $table
     * @return string
     */
    public function delete(string $table): string
    {
        $query =  "delete from %s where id = ?";
        return sprintf($query, $table);
    }
}