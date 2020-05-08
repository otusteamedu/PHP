<?php


namespace App\Repositories;

use App\DB\DBInterface;

/**
 * Class EventRepository
 * @package App\Repositories
 */
class EventRepository
{
    private DBInterface $db;

    public function __construct(DBInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $key
     * @param array $data
     * @return mixed
     */
    public function save(string $key, array $data)
    {
        return $this->db->save($key, $data);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params)
    {
        return $this->db->find($params);
    }


    public function deleteAll()
    {
        return $this->db->deleteAll();
    }
}