<?php 
namespace Own;
class EmailHelper
{
    public static function emailVerify($email = "")
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain = substr(strrchr($email, "@"), 1);
            $res = getmxrr($domain, $mx_records, $mx_weight);
            if (false == $res || 0 == count($mx_records) ||
                (1 == count($mx_records) &&
                    ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))) {
                echo "Нормальные mx-записи не обнаружены для домена: $domain";
                return false;
            }
        }
        else {
            echo "Данный адрес '$email' указан не верно";
            return false;
        }

        echo "Данный адрес - '$email' валидный и верифицированный";
        return true;
    }
}
