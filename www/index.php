<?php

include_once 'vendor/autoload.php';
$host = 'db';
$db = 'hw5';
$username = 'postgres';
$password = 'newDAy01';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
echo "<pre>";
try {
    $conn = \Tirei01\Hw12\Connector::getConnection($dsn);
    $obCategoryMapper = new \Tirei01\Hw12\Property\Mapper\Category($conn);
    $obCatFilm = $obCategoryMapper->find(3);
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    print_r(
        $obCatFilm
    );
    echo "</pre>";


    $obCatergoryCollection = new \Tirei01\Hw12\Property\Collection\Category();
    $obCatergoryCollection->add($obCategoryMapper->find(1));
    $obCatergoryCollection->add($obCategoryMapper->find(2));
    $obCatergoryCollection->add($obCategoryMapper->find(3));
    /**@var \Tirei01\Hw12\Property\Category $obCategory */
    foreach ($obCatergoryCollection as $obCategory) {
        // TODO DEL THIS
        echo "<pre style='color:red; clear: both;'>";
        var_dump($obCategory->getId(), $obCategory->getName(), $obCategory->getCode(), $obCategory->getSort());
        echo "</pre>";
    }




} catch (PDOException $e) {
    // report error message
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
}
echo "</pre>";
?>
