<?php
$host = '127.0.0.1';
$db = 'cinema';
$user = 'postgres';
$pass = '321';
$charset = 'utf8';
$dsn = "pgsql:host=$host;port=5432;dbname=$db";
$dbh = new PDO($dsn, $user, $pass);
$table_film = 'films_test';
$table_genres = 'film_genre';

$count = 100000;

try {
    for ($i = 0; $i < $count; ++$i) {
        $length = mt_rand(6, 12);
        $name = random_string($length);
        //чтобы 13-год встречался на порядок реже
        if (($i % 99) == 1) {
            $year = 2013;
        } else {
            $year = mt_rand(2014, 2019);
        }
        $sth = $dbh->prepare(' INSERT INTO ' . $table_film . ' 
    VALUES (:id,  :name,  :year)');
        $sth->execute([':id' => $i, ':name' => $name, ':year' => $year]);

        //Каждый фильм находится как минимум в двух разных категориях
        for ($j = 0; $j < 2; ++$j) {
            $genre = mt_rand(1, 12);

            $sth = $dbh->prepare(' INSERT INTO ' . $table_genres . ' 
            VALUES (:film_id, :genre_id)');
            $sth->execute([':film_id' => $i, ':genre_id' => $genre]);
        }

    }
} catch (\PDOException $exception) {
    var_dump($exception->getMessage());
}


function random_string($str_length)
{
    //$str_characters = array (0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

    $str_characters = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я'];

    // Возвращаем ложь, если первый параметр равен нулю или не является целым числом
    if (!is_int($str_length) || $str_length < 0) {
        return false;
    }

    // Подсчитываем реальное количество символов, участвующих в формировании случайной строки и вычитаем 1
    $characters_length = count($str_characters) - 1;

    // Объявляем переменную для хранения итогового результата
    $string = '';

    // Формируем случайную строку в цикле
    for ($i = $str_length; $i > 0; $i--) {
        $string .= $str_characters[mt_rand(0, $characters_length)];
    }

    // Возвращаем результат
    return $string;
}
