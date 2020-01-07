<?php
namespace App;
class UnixClient
{
    protected static $user = '';
    protected static $msg = '';

    public static function start($socket_file_name)
    {
        while (!self::$user) {
            echo "Введите имя пользователя или 'exit' для выхода:  ";
            self::$user = trim(fgets(STDIN));
            if (self::$user === 'exit') {
                exit();
            }
        }

        while (true) {
            echo "Напишите сообщение или 'exit' для выхода:  ";
            self::$msg = trim(fgets(STDIN));
            if (self::$msg === 'exit') {
                exit();
            } elseif (self::$msg) {
                try {
                    $sock = stream_socket_client('unix://./'.$socket_file_name.'.sock', $errno, $errstr);
                    if (is_resource($sock)) {
                        fwrite($sock, self::$user.": ".self::$msg);
                    } else {
                        echo "Не удалось создать сокет!" . PHP_EOL;
                    }
                } catch (Exception $e) {
                    echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
                }
            }
        }
    }
}