<?php


namespace App\DB;


interface DBInterface
{
    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function save(string $key, array $data);

    /**
     * @param $params
     * @return mixed
     */
    public function find(array $params);

    /**
     * @return mixed
     */
    public function deleteAll();
}