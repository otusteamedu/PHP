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
     */
    public function exec(Request $request): ResponseSuccess
    {
        //Проверяем что метод POST и авторизацию
        if ($request->isMethod(Request::METHOD_POST)) {
            $data = $request->get('string');
            if (empty($data)) {
                throw new RequestException('Error input data: empty string');
            }
    
            $result = new ResponseSuccess();
            $result->status = 'ok';
            $result->result = $data;
            
            return $result;
        }
        
        throw new RequestException('Not POST request');
    }
    
}
