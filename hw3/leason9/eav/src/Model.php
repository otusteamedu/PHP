<?php

namespace eav;
/**
 * Class Model
 *
 * @package eav
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
abstract class Model implements IModel
{
    /**
     * @var string
     */
    public $table;
    /**
     * @var \PDO
     */
    private $pdo;


    /**
     * Set PDO driver
     *
     * @param PDO $pdo
     *
     * @return $this
     */
    public function setPDO(PDO $pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }


    /**
     * Find by attributes
     *
     * @param array $attrs
     *
     * @return $this
     */
    public function findByAttr($attrs = [])
    {
        $sql    = 'select * from ' . $this->table;
        $params = $this->addParamsToSql($sql, $attrs);
        $res    = $this->execSql($sql, $params);
        $this->setAttributes($res);

        return $this;
    }


    /**
     * Выполнение SQL запроса
     *
     * @param string $sql
     * @param array  $params
     *
     * @return array
     */
    public function execSql($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }


    public function save()
    {
        $props  = get_class_vars(self::class);
        $sql    = 'insert into ' . $this->table . ' (';
        $fields = array_keys($props);
        $sql    .= implode(',', $fields);
        $sql    .= ') values (';
        $params = [];
        foreach ($props as $k => $v) {
            $paramName          = ':' . $k;
            $params[$paramName] = $v;
        }
        $sql .= implode(',', array_keys($params));

        return $this->execSql($sql, $params);
    }


    public function delete($attr = [])
    {
        $sql    = 'delete from ' . $this->table;
        $params = $this->addParamsToSql($sql, $attr);

        return $this->execSql($sql, $params);
    }


    /**
     * Set properties
     *
     * @param array $data
     *
     * @return $this
     */
    public function setAttributes($data)
    {
        foreach ($data as $k => $v) {
            if (property_exists(self::class, $k)) {
                $this->$k = $v;
            }
        }

        return $this;
    }


    private function addParamsToSql(&$sql, $data)
    {
        $params = [];
        if ( ! empty($data)) {
            $sql   .= ' where ';
            $total = count($data);
            $i     = 0;
            foreach ($data as $k => $v) {
                $paramName          = ':' . $k;
                $sql                .= $k . '= ' . $paramName;
                $params[$paramName] = $v;
                $i++;
                if ($i < $total) {
                    $sql .= ' AND ';
                }
            }
        }

        return $params;
    }
}