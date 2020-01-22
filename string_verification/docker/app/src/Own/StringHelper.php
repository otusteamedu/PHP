<?php 
namespace Own;
class StringHelper
{
    public static function stringVerify($string)
    {
        if (strlen($string) && !empty($string) && self::checkBrackets($string)) {
            echo "200 OK";
            return http_response_code(200);
        } else {
            echo "400 Bad Request";
            return http_response_code(400);
        }
    }

    private static function checkBrackets($string)
    {
        if ($string[0] == '(') {
            $balance = 1;
            foreach (str_split(substr($string, 1)) as $char) {
                echo PHP_EOL;
                if ($char == '(') {
                    $balance++;
                } elseif ($char == ')') {
                    $balance--;
                }

                if ($balance < 0) {
                    return false;
                }
            }
            return $balance == 0 ? true : false;
        } else {
            return false;
        }
    }
}
