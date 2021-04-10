<?php 

namespace Application;
use Validation\EmailValidator;
use Exception;

class App 
{
    private $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }
    
    private function checkArgument()
    {
        if(empty($_SERVER['argv'][1])) 
            throw new Exception("Аргумент для проверки не найден!");
    }

    public function run()
    {
        $this->checkArgument();
        $this->validator->checkEmail($_SERVER['argv'][1]);
    }
}