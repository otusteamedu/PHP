<?php

try {
    $db_name = 'otus';
    $db_user = 'developer';
    $db_pass = 'developer';
    $DB = new PDO("pgsql:host=pgsql;dbname={$db_name};user={$db_user};password={$db_pass}");
    echo 'PostgresSQL work!';
} catch (PDOException $e) {
    echo $e->getMessage();
}

phpinfo();