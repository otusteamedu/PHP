<?php


namespace App\DB;


interface DBInterface
{
    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function save($key, $data);

    /**
     * @param $params
     * @return mixed
     */
    public function find($params);

    /**
     * @return mixed
     */
    public function deleteAll();
}