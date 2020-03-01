<?php

namespace Tirei01\Hw12\Mvc;

class Controller
{
    private $model;
    protected string $title;
    protected string $redirect;
    protected array $data;
    public function __construct($model) {
        $this->model = $model;
        $this->title = '';
        $this->redirect = '';
        $this->data = array();
    }
    public function clicked() {
        $this->model->string = '“Updated Data, thanks to MVC and PHP!”';
    }
    public function getData(){
        return $this->data;
    }
    public function getTitle(){
        return $this->title;
    }
    protected function getModel(){
        return $this->model;
    }
    protected function setRedirect(string $redirect){
        $this->redirect = $redirect;
    }
    public function getRedirect() : string {
        return $this->redirect;
    }
}