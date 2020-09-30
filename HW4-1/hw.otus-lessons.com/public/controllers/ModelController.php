<?php


namespace App\Controllers;


class ModelController
{
    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
    }
}