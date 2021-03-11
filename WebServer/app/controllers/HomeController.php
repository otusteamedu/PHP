<?php

namespace Controllers;

use Core\Request;
use Core\View;

class HomeController
{
    public function show()
    {
        $view = new View('form');
        return $view->show();
    }

    public function validate()
    {
        $request = Request::getInstance();
        $post = $request->getPost();
        $string = $post['string'];
        $result = 'success';

        if(!$this->checkLength($string) || !$this->checkBrackets($string)){
            $result = 'error';
        }

        header("Location: /" .$result);
        exit();
    }

    public function showSuccess()
    {
        $view = new View('success');
        return $view->show();
    }

    public function showError()
    {
        $view = new View('error');
        http_response_code(400);
        return $view->show();
    }

    private function checkLength(string $string) : bool
    {
        return strlen($string) >= 2;
    }

    private function checkBrackets(string $string) : bool
    {
        $length = strlen($string);
        $openBrackets = 0;
        $closeBrackets = 0;

        for($i = 0; $i < $length; $i++){
            if($string[$i] === '('){
                $openBrackets++;
                continue;
            }
            if($string[$i] === ')'){
                $closeBrackets++;
            }

            if($openBrackets < $closeBrackets){
                return false;
            }
        }

        return true;
    }

}