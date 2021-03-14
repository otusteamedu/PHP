<?php 

namespace Application;
use Http\Request;
use Http\Response;

class App
{
    private $request;
    private $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run()
    {
        if(!$this->request->isPostRequest()) 
            return $this->response->response(false, "Метод запроса не является корректным!");
        
        if(!$this->request->hasParam('string'))
            return $this->response->response(false, "Отсутствует необходимый параметр 'string'");

        $validation = $this->request->validator->checkString($this->request->getParam('string'));

        return $this->response->response($validation[0], $validation[1]);
        
    }
}