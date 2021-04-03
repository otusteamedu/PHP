<?php 

namespace Validation;

class EmailValidator
{
    public function __construct()
    {

    }

    private function checkTemplate($string)
    {
        if(preg_match('/[a-zA-Z0-9\.\-_]+@[a-zA-Z0-9\.\-_]+\.[a-z]{1,5}/', $string)) return;
        exit("Строка не соответствует шаблону электронной почты! \n");
    }

    private function checkMX($string)
    {
        $domain = explode('@', $string);
        $check = getmxrr($domain[1], $mx_records, $mx_weight);
        if($check) return;

        exit("MX записей не найдено! \n");
    }

    private function checkDNS($string)
    {
        $domain = explode('@', $string);
        $check = checkdnsrr($domain[1], 'MX');
        if($check) return;

        exit("DNS запией не найдено! \n");
    }

    public function checkEmail($string)
    {
        $this->checkTemplate($string);
        $this->checkMX($string);
        $this->checkDNS($string);
        exit("Почтовый адрес \"".$string."\" успешно прошел проверку! \n");
    }
}