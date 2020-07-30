<?php

namespace Classes\Models;

class Package extends AbstractActiveRecord
{
    protected $id;
    protected $batch; // партия

    protected static $tableName = 'pakages';


    public function getId()
    {
        return $this->id;
    }

    public function getBatch()
    {
        return $this->batch;
    }

    public function setBatch(int $batch)
    {
        $this->batch = $batch;
    }
}
