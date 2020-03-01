<?php


namespace HW;


class App
{
    private $httpRespCode = 400;
    private $httRespMsg = 'Fail: string is not valid ((';

    public static function run()
    {
        $inst = new static();
        $inst->output();
    }

    private function __construct()
    {
        $this->httpRespCode = 400;

        if ($this->checkPostData()) {
            $this->httpRespCode = 200;
            $this->httRespMsg = "Success: string is valid!";
        }
    }

    private function checkPostData()
    {
        $string = $_REQUEST['string'] ?? '';

        $sv = new StringValidator($string);
        return $sv->validate();
    }

    private function output()
    {
        http_response_code($this->httpRespCode);
        echo $this->httRespMsg;
    }

}