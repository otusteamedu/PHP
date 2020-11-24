<?php

namespace sources;

class RowDataGataway implements IGateway
{
    public $tableName = 'user';

    private $db;

    public function __construct($db, $id){
        $this->db = $db;
    }

    public function insert()
    {
        $this->db->insert($this->tableName, $this->getAttributes());
    }


    public function update()
    {
        // TODO: Implement update() method.
    }


    public function fetch()
    {
        // TODO: Implement fetch() method.
    }


    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function getAttributes(){
        get_class_vars(__self__);
    }
}