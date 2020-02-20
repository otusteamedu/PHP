<?php

use Responses\ResponseSuccess;
use Exceptions\RequestException;
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
            $data = $_SERVER['REMOTE_ADDR'];

            $result         = new ResponseSuccess();
            $result->status = 'ok';
            $result->result = "String: {$data} is valid";

            return $result;
        }
        
        throw new RequestException('Not POST request');
    }
    
}
