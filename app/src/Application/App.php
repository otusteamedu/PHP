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
        echo "Текущая нода: ". $_SERVER['SERVER_ADDR']."\n";

    }
}
