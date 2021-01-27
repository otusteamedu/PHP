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
    public function __construct()
    {
        echo "<form action='/' method='post'>
                <textarea name='arr_email' placeholder='Введите email через ; :'></textarea>
                <br/>
                <input type='submit' value='Проверить'>
              </form>";

    }

    public function review($arr) {
        $arrEmail = array();
        if (gettype($arr) == "array" && !empty($arr['arr_email'])) {
            $arrEmail = explode(";", $arr['arr_email']);
        } elseif (gettype($arr) == 'string') {
            $arrEmail = explode(";", $arr);
        } else {
            throw new Exception("Передан не верный тип данных!");
        }

        foreach ($arrEmail as $email) {
            $str = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $email);
            $str = str_replace(array("\r\n", "\r", "\n", "\t", ' ', '    ', '    '), '', $str);
            if (!self::review1level($str)) {
                echo $email." - не прошел валидацию 1 уровня по регулярному выражению.<br/>";
            } elseif (!self::review2level($str)) {
                echo $email." - не прошел валидацию 2 уровня по MX записям.<br/>";
            } else {
                echo $email." - является валидным E-mail адресом<br/>";
            }
        }
    }

    public function review1level(string  $email) {
        return preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email);
    }

    public function review2level(string  $email) {
        $str = explode("@", $email);
        return getmxrr($str[1], $email);
    }
}