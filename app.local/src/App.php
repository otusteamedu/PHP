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
//        if ($request->isMethod(Request::METHOD_POST)) {
//            $data = $request->get('string');
//            if (empty($data)) {
//                throw new RequestException('Error input data: empty string');
//            }
//            if (!is_string($data)) {
//                throw new RequestException('Error input data: not string');
//            }
//
//            $checkBrackets = new \Library\CheckBrackets();
//            if (!$checkBrackets->isValid($data)) {
//                throw new RequestException('Error input data: incorrect string');
//            }
//
//            $result         = new ResponseSuccess();
//            $result->status = 'ok';
//            $result->result = "String: {$data} is valid";
//
//            return $result;
//        }
        return $_SERVER['REMOTE_ADDR'];
        
        throw new RequestException('Not POST request');
    }
    
}
