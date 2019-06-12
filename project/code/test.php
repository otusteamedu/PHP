<?
echo "hello i am php";
$servername = '127.0.0.1:3306';
$username = 'root';
$password = 'root333';

$link = mysqli_connect("127.0.0.1", "root", "root333", "db");

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
