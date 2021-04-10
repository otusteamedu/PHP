<?php 

namespace Validation;
use Exception;

class EmailValidator
{
    public function __construct()
    {

    }

    private function checkTemplate($string)
    {
        if(!preg_match('/[a-zA-Z0-9\.\-_]+@[a-zA-Z0-9\.\-_]+\.[a-z]{1,5}/', $string)) 
            throw new Exception("Строка не соответствует шаблону электронной почты!");
    }

    private function checkMX($string)
    {
        $domain = explode('@', $string);
        $check = getmxrr($domain[1], $mx_records, $mx_weight);
        if(!$check) 
            throw new Exception("MX записей не найдено!");
    }

    private function checkDNS($string)
    {
        $domain = explode('@', $string);
        $check = checkdnsrr($domain[1], 'MX');
        if(!$check) 
            throw new Exception("DNS запией не найдено!");
    }

    public function checkEmail($string)
    {
        $this->checkTemplate($string);
        $this->checkMX($string);
        $this->checkDNS($string);
        echo "Почтовый адрес \"".$string."\" успешно прошел проверку! \n";
    }
}