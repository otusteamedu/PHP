<?php

use Library\CheckEmail;
use Responses\ResponseSuccess;
use Exceptions\RequestException;
use Library\CheckEmailException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class App
 */
class App
{
    
    /**
     * @param Request $request
     *
     * @return ResponseSuccess
     * @throws RequestException
     */
    public function exec(Request $request): ResponseSuccess
    {
        //Проверяем что метод POST и авторизацию
        if ($request->isMethod(Request::METHOD_GET)) {
            $email = $request->get('email');
            if ($email === null) {
                throw new RequestException('Empty email');
            }
            $ip           = $_SERVER['SERVER_ADDR'];
            $checkEmail   = new CheckEmail();
            $isValidEmail = $checkEmail->isValid($email);
            
            $result         = new ResponseSuccess();
            $result->status = 'ok';
            $result->result = $isValidEmail ? "{$email} is valid" : "{$email} is not valid";
            $result->ip     = $ip;
            
            return $result;
        }
        
        throw new RequestException('Not POST request');
    }
    
}
