<?php


namespace App;


class Util
{
    public static function dump($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    public static function getEmails()
    {
        $emails = [];
        while (true) {
            $input = self::readFromSTDIN();
            if ($input == 'exit') break;
            $emails[] = $input;
        }
        return $emails;
    }

    public static function readFromSTDIN()
    {
        return rtrim(fgets(STDIN));
    }
}