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
            $data = $_SERVER['SERVER_ADDR'];

            $result         = new ResponseSuccess();
            $result->status = 'ok';
            $result->result = "IP: {$data}";

            return $result;
        }
        
        throw new RequestException('Not POST request');
    }
    
}
