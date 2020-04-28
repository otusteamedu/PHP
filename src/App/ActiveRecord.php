<?php
namespace Ozycast\App;

abstract class ActiveRecord
{
    protected $_error;

    /**
     * Имя коллекции/таблицы
     * @return string
     */
    abstract public static function getCollectName(): string;

    abstract public function save(): bool;
    abstract public function update(): bool;

    public function __construct($data = [])
    {
        $this->serialize($data);
    }

    /**
     * @param array $params
     * @return ActiveRecord | null
     */
    public static function find($params)
    {
        $db = App::$db->findOne(static::getCollectName(), $params);
        $model = $db ? (new static)->serialize($db) : null;
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    public function findAll($params = []): array
    {
        $db = App::$db->findAll($this->getCollectName(), $params);
        return $this->serializeAll($db);
    }

    /**
     * @param array|object $data
     * @return ActiveRecord
     */
    public function serialize($data): ActiveRecord
    {
        if (empty($data))
            return $this;

        foreach (get_class_vars(get_class($this)) as $key => $param) {
            if (isset($data[$key]))
                $this->$key = $data[$key];
        }

        return $this;
    }

    /**
     * @param array $datas
     * @return array
     */
    public function serializeAll(array $datas): array
    {
        if (empty($datas))
            return [];

        $models = [];
        foreach ($datas as $data) {
            $model = (new static)->serialize($data);
            $models[] = $model;
        }

        return $models;
    }

    public function getError(): string
    {
        return $this->_error;
    }
}