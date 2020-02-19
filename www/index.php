<?php
include_once 'vendor/autoload.php';
$conn = \Tirei01\Hw12\Connector::getConnection();
$obMapElement = new \Tirei01\Hw12\Storage\Mapper\Element();
$elems = $obMapElement->findAll();
foreach ($elems as $elem) {
    // TODO DEL THIS
    echo "<pre style='color:red; clear: both;'>";
    var_dump($elem);
    echo "</pre>";
}
?>
<a href="/admin.php">adminka</a>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">