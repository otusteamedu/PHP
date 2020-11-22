<?php
include "vendor/autoload.php";

$entity = new \eav\Entity('film');
$attr1 = new \eav\Attribute('Name', 'string');
$attr2 = new \eav\Attribute('Budget', 'float');

$value1 = new \eav\Value($entity, $attr1, 'Test film');
$value2 = new \eav\Value($entity, $attr2, 2350.23);
