<?php


namespace HW\ActiveRecords;


class Session extends ActiveRecord
{

    protected static function getTableName()
    {
        return 'sessions';
    }

    /**
     * @inheritDoc
     */
    protected static function getFieldsNames()
    {
        return ['hall_id', 'time_from', 'time_to'];
    }

    public function getHallID()
    {
        return $this->getFieldValue('hall_id');
    }

    public function setHallID($value)
    {
        return $this->setFieldValue('hall_id', $value);
    }

    public function getTimeFrom()
    {
        return $this->getFieldValue('time_from');
    }

    public function setTimeFrom($value)
    {
        return $this->setFieldValue('time_from', $value);
    }

    public function getTimeTo()
    {
        return $this->getFieldValue('time_to');
    }

    public function setTimeTo($value)
    {
        return $this->setFieldValue('time_to', $value);
    }

    public static function getAll(\PDO $pdo, $hallID)
    {
        return static::getCollection($pdo, "hall_id = $hallID");
    }
}