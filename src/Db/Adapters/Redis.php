<?php

namespace Bjlag\Db\Adapters;

use Bjlag\Db\Store;

class Redis implements Store
{
    /** @var \Predis\Client */
    private $client;

    /**
     * @param string $uri
     * @param string $dbname
     * @return $this
     */
    public function getConnection(string $uri, string $dbname)
    {
        $this->client = new \Predis\Client($uri);
        return $this;
    }

    /**
     * @param string $from
     * @param array $select
     * @param array $where
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function find(
        string $from,
        array $select = [],
        array $where = [],
        ?int $limit = null,
        ?int $offset = null
    ): array {
        return $this->client->hgetall($from);
    }

    /**
     * @param string $to
     * @param array $data
     * @return int
     */
    public function add(string $to, array $data): int
    {
        $inserted = 0;
        foreach ($data as $key => $item) {
            $result = $this->client->hsetnx($to, $key, json_encode($item));
            $inserted += (int) $result;
        }

        return $inserted;
    }

    /**
     * @param string $table
     * @param array $where
     * @return int
     */
    public function delete(string $table, array $where): int
    {
        $deleted = 0;
        foreach ($where as $field) {
            $result = $this->client->hdel($table, $field);
            $deleted += $result;
        }

        return $deleted;
    }

    /**
     * @param string $table
     * @return int
     */
    public function deleteAll(string $table): int
    {
        $keys = $this->client->hkeys($table);
        return $this->client->hdel($table, $keys);
    }

    /**
     * @param string $table
     * @param array $where
     * @param array $data
     */
    public function update(string $table, array $where, array $data)
    {
        throw new \DomainException('Обновление не реализовано.');
    }
}
