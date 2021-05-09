<?php 

namespace Application;

use Exception;

class App 
{
    private $validator;

    public function __construct()
    {
       
    }

    public function run()
    {
        echo "Текшая нода: ". $_SERVER['SERVER_ADDR']."\n";

    }
}