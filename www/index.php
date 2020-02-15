<?php

include_once 'vendor/autoload.php';
$host = 'db';
$db = 'test';
$username = 'postgres';
$password = 'newDAy01';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
echo "<pre>";
try {
    $conn = \Tirei01\Hw12\Connector::getConnection($dsn);

    var_dump(class_exists('\\Tirei01\\Hw12\\Test\\Test'));
    var_dump(class_exists('\Tirei01\Hw12\DomainObject'));
    var_dump(class_exists('\Tirei01\Hw12\Mapper'));
    $obFilm = new \Tirei01\Hw12\Cinema\FilmMapper($conn);
    $obCategoryMapper = new \Tirei01\Hw12\Property\Mapper\Category($conn);
    $obCategory = new \Tirei01\Hw12\Property\Category(0, 'Фильм', 100, 'film');
    $obCategoryMapper->insert($obCategory);
    // TODO DEL THIS
    echo "<pre style='color:#6527ff; clear: both;'>";
    var_dump($obCategory->getId(), $obCategory);
    echo "</pre>";
    /*
    $obCategory = new \Tirei01\Hw12\Property\Category(0, 'Зал', 50, 'hall');
    $obCategoryMapper->insert($obCategory);
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($obCategory);
    echo "</pre>";
    $obCategory = new \Tirei01\Hw12\Property\Category(0, 'Места', 60, 'film');
    $obCategoryMapper->insert($obCategory);
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r($obCategory);
    echo "</pre>";
    */
    //$obCollection = new \Tirei01\Hw12\Cinema\FilmCollection();
    //$obCollection->add($obFilm->find(15));
    //$obCollection->add($obFilm->find(16));
    //$obCollection->add($obFilm->find(17));
    //
    //foreach ($obCollection as $film) {
    //     TODO DEL THIS
        //echo "<pre style='color:red; clear: both;'>";
        //var_dump($film);
        //echo "</pre>";
    //}


    /*
    //$needAdd = new \Tirei01\Hw12\Cinema\Film(0, 'Самара');
    //$obFilm->insert($needAdd);

    // TODO DEL THIS
    echo "<pre style='color:#ff42b1; clear: both;'>";
    //var_dump($needAdd);
    echo "</pre>";

    $resFilm = $obFilm->find(15);
    $resFilm->setName('Rename '.$resFilm->getName());
    $obFilm->update($resFilm);
    $resFilm = $obFilm->find(15);
    // TODO DEL THIS
    echo "<pre style='color:#6527ff; clear: both;'>";
    var_dump($resFilm);
    echo "</pre>";
    */
} catch (PDOException $e) {
    // report error message
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
}
echo "</pre>";
?>
