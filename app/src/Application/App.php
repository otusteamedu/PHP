<?php 

namespace Application;


class App
{

    private $side; 

    public function __construct()
    {
        $this->side = ucfirst($_SERVER['argv'][1]);
    }

    public function run()
    {
        $app_name = '\\Application\\'.$this->side;
        
        if(class_exists($app_name)){
            $app = new $app_name();
            $app->run();
        }else{
            echo "Ошибка! Аргумент \"".$_SERVER['argv'][1]."\" не поддерживается! \n";
        }
    }

}