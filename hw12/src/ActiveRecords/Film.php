<?php


namespace HW\ActiveRecords;


class Film extends ActiveRecord
{

    protected static function getTableName()
    {
        return 'films';
    }

    /**
     * @inheritDoc
     */
    protected static function getFieldsNames()
    {
        return ['name', 'duration'];
    }


    public function getName()
    {
        return $this->getFieldValue('name');
    }

    public function setName($name)
    {
        return $this->setFieldValue('name', $name);
    }

    public function getDuration()
    {
        return $this->getFieldValue('duration');
    }

    public function setDuration($duration)
    {
        return $this->setFieldValue('duration', $duration);
    }

}