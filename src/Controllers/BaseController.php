<?php


namespace src\Controllers;


use src\Models\BaseModel;

abstract class BaseController
{
    protected ?BaseModel $model;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    protected function getModel()
    {
        $class = explode('\\', get_class($this));
        $model = 'src\Models\\' . mb_ereg_replace('Controller', '', $class[2]) . 'Model';
        return class_exists($model) ? new $model : null;
    }


}
