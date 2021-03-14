<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 04.01.21
 * Time: 20:51
 */

namespace EmailValid;

use Exception;

class EmailValid
{

    public function review(string $emails) {
        $arrEmail = array();
        if (gettype($emails) == 'string') {
            $arrEmail = explode(";", $emails);
        } else {
            throw new Exception("Передан не верный тип данных!");
        }

        foreach ($arrEmail as $email) {
            $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $email);
            $str = str_replace(array("\r\n", "\r", "\n", "\t", ' ', '    ', '    '), '', $str);
            if (self::review1level($str) && self::review2level($str)) {
                echo $email." - является валидным E-mail адресом<br/>";
            }
        }
    }

    public function review1level(string  $email) {
        if(preg_match('/^(([0-9A-zА-я]{1}[-0-9A-zА-я\.]{1,}[0-9A-zА-я]{1})@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email)){
            return true;
        }
        echo $email." - не прошел валидацию 1 уровня по регулярному выражению.<br/>";
        return false;
    }

    public function review2level(string  $email) {
        $for_error = $email;
        $str = explode("@", $email);
        if (getmxrr($str[1], $email)){
            return true;
        }
        echo $for_error." - не прошел валидацию 2 уровня по MX записям.<br/>";
        return false;

    }
}
