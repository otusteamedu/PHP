<?php 

namespace Http;

class Response
{
    public function __construct()
    {
        
    }

    public function response($answer, $body)
    {
        header('HTTP/1.1 '.$this->getHeader($answer));
        echo $body."\n";
        return;
    }

    private function getHeader($correct)
    {
        return ($correct) ? '200 OK' : '400 Bad Request';
    }

}