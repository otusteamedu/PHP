<?php


namespace App;


class MySQLQueries
{
    /**
     * @return string
     */
    public function insert(): string
    {
        return "insert into products (title, description, price) values (?, ?, ?)";
    }

    /**
     * @return string
     */
    public function update(): string
    {
        return "update products set title = ?, description = ?, price = ? where id = ?";
    }

    /**
     * @return string
     */
    public function delete(): string
    {
        return "delete from products where id = ?";
    }

    /**
     * @return string
     */
    public function findByID(): string
    {
        return "select * from products where id = ?";
    }

    /**
     * @return string
     */
    public function findAll(): string
    {
        return "select * from products";
    }

}