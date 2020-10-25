<?php

class App
{
    public  $minLength;
    private $httpRequest;
    private $httpResponse;


    public function __construct(int $minLength = 20, $request = null, $response = null)
    {
        $this->minLength    = $minLength;
        $this->httpRequest  = $request ?? (new HttpRequest());
        $this->httpResponse = $response ?? (new HttpResponse());
    }


    public function run()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getParam('string');
            if ( ! empty($data) && strlen($data) > $this->minLength) {
                $checker = new Checker();
                if ($checker->check($data)) {
                    $this->response->send(200, 'Последовательность верная');
                } else {
                    $this->response->send(500, 'Последовательность не верная');
                }
            } else {
                $this->response->send(500, 'Не корректная длина строки');
            }
        } else {
            $this->response->send(500, 'Необходимо отправить POST-запрос');
        }
    }
}