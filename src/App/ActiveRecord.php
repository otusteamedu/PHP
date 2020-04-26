<?php
namespace Ozycast\App;

abstract class ActiveRecord
{
    protected $_error;

    /**
     * Имя коллекции/таблицы
     * @return mixed
     */
    abstract public static function getCollectName();
    abstract public function save();
    abstract public function update();

    public function __construct($data = [])
    {
        $this->serialize($data);
    }

    public static function find($params)
    {
        $bd = App::$db->findOne(static::getCollectName(), $params);
        $model = $bd ? (new static)->serialize($bd) : null;
        return $model;
    }

    public function findAll($params = [])
    {
        $bd = App::$db->findAll($this->getCollectName(), $params);
        return $this->serializeAll($bd);
    }

    public function serialize($data)
    {
        if (empty($data))
            return $this;

        foreach (get_class_vars(get_class($this)) as $key => $param) {
            if (isset($data[$key]))
                $this->$key = $data[$key];
        }

        return $this;
    }

    public function serializeAll($datas)
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

    public function getError()
    {
        return $this->_error;
    }
}