<?php

namespace hw23\db;

use hw23\App;

class ActiveRecord
{
    public static function getDb()
    {
        return App::getInstance()['db'];
    }

    public static function tableName(): string
    {
        $split = preg_split('/(?=[A-Z])/', get_called_class());
        return strtolower($split[count($split) - 1]);
    }

    /**
     * @param array $conditions
     * @return string
     */
    public static function prepareConditions(array $conditions): string
    {
        $out = '';
        foreach ($conditions as $key => $condition) {
            if (!empty($out)) {
                $out .= "AND ";
            }
            $out .= "{$key} = {$condition}";
        }
        return $out;
    }

    /**
     * @param array $conditions ['id' => 1, 'publisher_id' => 3]
     * @return mixed
     */
    public static function getOne(array $conditions)
    {
        $db = self::getDb();
        $data = $db->getOne('SELECT * FROM ' . self::tableName() . ' WHERE ' . self::prepareConditions($conditions));
        return Container::createObject(get_called_class(), $data);
    }

    /**
     * @param array $conditions ['publisher_id' => 3]
     * @return mixed
     */
    public static function getAll(array $conditions)
    {
        $db = self::getDb();
        $data = $db->getAll('SELECT * FROM ' . self::tableName() . ' WHERE ' . self::prepareConditions($conditions));
        $out = [];
        foreach ($data as $dataRow) {
            $out[] = Container::createObject(get_called_class(), $dataRow);
        }
        return $out;
    }

    /**
     * get object with identity map check
     * @param int $id
     * @return mixed
     */
    public static function getById(int $id)
    {
        if (App::getInstance()['objectWatcher']->getObject(get_called_class(), $id) === null) {
            $obj = self::getOne(['id' => $id]);
            App::getInstance()['objectWatcher']->addObject($obj, $id);
            return $obj;
        } else {
            return App::getInstance()['objectWatcher']->getObject(get_called_class(), $id);
        }
    }


}