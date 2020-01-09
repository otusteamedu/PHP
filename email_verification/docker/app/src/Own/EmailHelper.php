<?php 
namespace Own;
class EmailHelper
{
    public static function emailVerify($emails = [])
    {

        foreach ($emails as $email) {
            $email = trim($email);
            $is_valid = true;

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $domain = substr(strrchr($email, "@"), 1);
                $res = getmxrr($domain, $mx_records, $mx_weight);
                if (false == $res || 0 == count($mx_records) ||
                    (1 == count($mx_records) &&
                        ($mx_records[0] == null || $mx_records[0] == "0.0.0.0"))) {
                    echo "Нормальные mx-записи не обнаружены для домена: $domain у адреса - '$email' <br>";
                    $is_valid &= false;
                }
            }
            else {
                echo "Адрес '$email' указан не верно <br>";
                $is_valid &= false;
            }

            if ($is_valid) {
                echo "Адрес '$email' валидный и верифицированный <br>";
            }
        }

        return true;
    }
}
