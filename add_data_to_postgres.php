<?php

include_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$faker = Faker\Factory::create();

$driver = $_ENV['driver'] ?? null;
$dbname = $_ENV['dbname'] ?? null;
$host   = $_ENV['host']   ?? null;
$user   = $_ENV['user']   ?? null;
$pass   = $_ENV['pass']   ?? null;

if (isset($driver) && isset($dbname) && isset($host) && isset($user) && isset($pass)) {
    $dbh = new PDO("{$driver}:dbname={$dbname};host={$host}", $user, $pass);

    # TODO remove all
    $statement = $dbh->prepare('DELETE FROM public.cinemas');

    if ($statement) {
        $statement->execute();
    }
    
//                                 QUERY PLAN 10000 DELETE                             
// -------------------------------------------------------------------
//    Delete on cinemas  (cost=0.00..175.50 rows=11050 width=6)
//    ->  Seq Scan on cinemas  (cost=0.00..175.50 rows=11050 width=6)

//                                  QUERY PLAN 100000 DELETE                              
// ---------------------------------------------------------------------
//  Delete on cinemas  (cost=0.00..1647.00 rows=100000 width=6)
//    ->  Seq Scan on cinemas  (cost=0.00..1647.00 rows=100000 width=6)
//    (2 rows)


    # TODO add 10000 writes
    // for ($i=1; $i <= 10000; $i++) {
    //     $statement = $dbh->prepare('INSERT INTO public.cinemas ("name") VALUES (:name)');
    //
    //     if ($statement) {
    //         $statement->bindValue(':name', $faker->name);
    //         $statement->execute();
    //     }
    // }


    # TODO add 100000 writes
    for ($i=1; $i <= 100000; $i++) {
        $statement = $dbh->prepare('INSERT INTO public.cinemas ("name") VALUES (:name)');

        if ($statement) {
            $statement->bindValue(':name', $faker->name);
            $statement->execute();
        }
    }
} else {
    echo "Error: db no connection.";
}



