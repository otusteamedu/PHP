<?php

namespace Classes\Models;

class Package extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'pakages';

    public function getName()
    {
        return $this->name;
    }
}
