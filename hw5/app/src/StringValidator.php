<?php


namespace HW;


class StringValidator
{
    private $string = '';

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function validate()
    {
        if (!$this->checkLength())
            return false;

        return $this->checkContent();
    }

    private function checkContent()
    {
        $tpl = '/\([^)(]*\)/';

        $string = $this->string;
        while(preg_match($tpl, $string))
            $string = preg_replace($tpl, "", $string);

        return !preg_match('/[)(]/', $string);
    }

    //TODO - не понятно надо ли было проверять на длину 48
    private function checkLength()
    {
        return strlen($this->string) > 0; // > 48
    }

}