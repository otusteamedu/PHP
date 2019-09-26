<?php

require_once 'vendor/autoload.php';

use MyApp\UserMapper;

try {
    $dbuser = 'root';
    $dbpass = 'yadirect';
    $dbname = 'otusttest';

    $dbh = new PDO('mysql:host=localhost;dbname=' . $dbname, $dbuser, $dbpass);

    $db = new UserMapper($dbh);

    $newUser = [
        'firstname' => 'Alex',
        'lastname'  => 'Zolotukhin',
        'phone'     => '1234567891',
        'company'   => 'student'
    ];
    $user = $db->insert($newUser);

    echo $user->getFirstname();

} catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

