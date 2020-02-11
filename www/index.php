<?php

include_once 'vendor/autoload.php';
$host = 'db';
$db = 'test';
$username = 'postgres';
$password = 'newDAy01';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
try {
    $conn = \Tirei01\Hw12\Connector::getConnection($dsn);
    echo "<pre>";
    var_dump(class_exists('\\Tirei01\\Hw12\\Test\\Test'));
    var_dump(class_exists('\Tirei01\Hw12\DomainObject'));
    var_dump(class_exists('\Tirei01\Hw12\Mapper'));
    echo "</pre>";

    $obFilm = new \Tirei01\Hw12\Cinema\FilmMapper($conn);
    //
    $resFilm = $obFilm->find(1);
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    var_dump($obFilm, $resFilm);
    echo "</pre>";
} catch (PDOException $e) {
    // report error message
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
}
?>
