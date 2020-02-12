<?php

use Entities\InputData;
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
     * @throws \Exceptions\ConvertException
     */
    public function exec(Request $request): ResponseSuccess
    {
        $result = new ResponseSuccess();
        
        //Проверяем что метод POST и авторизацию
        if ($request->isMethod(Request::METHOD_POST)) {
        
        } else {
            throw new RequestException('Error input data: empty string');
        }
        
        return $result;
    }
    
    
}
