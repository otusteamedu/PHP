<?php 

namespace Application;
use Validation\EmailValidator;

class App 
{
    private $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }
    
    private function checkArgument()
    {
        if(empty($_SERVER['argv'][1])) exit("Аргумент для проверки не найден! \n");
    }

    public function run()
    {
        $this->checkArgument();
        $this->validator->checkEmail($_SERVER['argv'][1]);
    }
}