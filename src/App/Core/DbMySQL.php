<?php
namespace Ozycast\App\Core;

use \PDO;

Class DbMySQL implements Db
{
    private $db;

    public function connect(): Db
    {
        if ($this->db)
            return $this->db;

        $username = $_ENV["MYSQL_USER"];
        $password = $_ENV["MYSQL_PASSWORD"];
        $host = $_ENV["MYSQL_HOST"];
        $db = $_ENV["MYSQL_DB"];

        try {
            $this->db = new PDO("mysql:dbname=$db;host=$host", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (\PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * @param array $table
     * @param array $rows
     * @return int
     */
    public function insert($table, $rows): int
    {
        $sql_params = [];
        foreach ($rows as $key => $attr) {
            $sql_params[":$key"] = $attr;
        }
        $sql_rows = implode(',', array_keys($rows));
        $sql_params_name = implode(',', array_keys($sql_params));

        $query = $this->db->prepare("INSERT INTO $table ($sql_rows) VALUES ($sql_params_name)");
         if (!$query->execute($sql_params))
            return 0;

        return $this->db->lastInsertId();
    }

    /**
     * @param array $table
     * @param array $filter
     * @param array $rows
     * @return bool
     */
    public function update($table, $filter, $rows): bool
    {
        $sql_params = [];
        $sql_rows = [];
        foreach ($rows as $key => $attr) {
            $sql_params[":".$key] = $attr;
            if ($key != 'id')
                $sql_rows[] = $key." = :".$key;
        }
        $sql_rows = implode(', ', $sql_rows);

        $filter = $this->parseAttributesForWhere($filter);
        $sql_params = array_merge($sql_params, $filter['rows']);

        $query = $this->db->prepare("UPDATE $table SET $sql_rows " . $filter['where']);
        return $query->execute($sql_params);
    }

    /**
     * @param array $table
     * @param array $rows
     * @return object|null
     */
    public function  findAll($table, $rows)
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->db->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);
        return $query->fetchAll();
    }

    /**
     * @param $table
     * @param $rows
     * @return object|null
     */
    public function findOne($table, $rows)
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->db->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);
        return $query->fetch();
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function parseAttributesForSelect(array $attributes): array
    {
        $where = '';
        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as $key => $attr) {
            $sql_rows[':'.$pref.$key] = $attr;
            $sql_params[] = $key ." = :".$pref.$key;
        }
        $sql_params = implode($glue, $sql_params);

        if (!empty($attributes))
            $where = ' WHERE ' . $sql_params;

        return ['where' => $where, 'rows' => $sql_rows];
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function parseAttributesForWhere(array $attributes): array
    {
        $where = '';
        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as $key => $attr) {
            $sql_rows[':where_'.$key] = $attr;
            $sql_params[] = $key ." = :where_".$key;
        }
        $sql_params = implode(" AND ", $sql_params);

        if (!empty($attributes))
            $where = ' WHERE ' . $sql_params;

        return ['where' => $where, 'rows' => $sql_rows];
    }
}