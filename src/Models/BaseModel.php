<?php


namespace src\Models;


use Services\Dao\DaoService;

/**
 * Class BaseModel
 * @package src\Models
 */
abstract class BaseModel
{
    protected DaoService $dataAccess;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->dataAccess = new DaoService();
    }

    public function get()
    {

    }

}
