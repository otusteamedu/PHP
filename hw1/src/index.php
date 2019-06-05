<?php

$servername = "mysql";
$user = "root";
$pass = "password";

echo 'QWEQWE';

try {
    $conn = new PDO("mysql:host=mysql;port=3306;dbname=example", $user, $pass);

    var_dump($conn);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

echo '<br/>' . 'hello world!!!';

phpinfo();

//WARNING: Service "mysql" is using volume "/var/lib/mysql" from the previous container. Host mapping "hw1_mysql" has no effect.
//Remove the existing containers (with `docker-compose rm mysql`) to use the host volume mapping.

//WARNING: Service "mysql" is using volume "/var/lib/mysql" from the previous container.
//Host mapping "hw1_hw1_mysql" has no effect. Remove the existing containers (with `docker-compose rm mysql`) to use the host volume mapping.


//WARNING: Service "mysql" is using volume "/var/lib/mysql" from the previous container. Host mapping "hw1_qwe" has no effect.
//Remove the existing containers (with `docker-compose rm mysql`) to use the host volume mapping.
