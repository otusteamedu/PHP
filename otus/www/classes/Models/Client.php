<?php

namespace Classes\Models;

class Client extends AbstractActiveRecord
{
    protected $id;
    protected $name;
    protected $address;

    protected static $tableName = 'clients';

}
