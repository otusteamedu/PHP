<?php

use crazydope\theater\database\ResultSet;
use crazydope\theater\model\Movie;
use crazydope\theater\database\IdentityMap;

require '../vendor/autoload.php';

$adapter = new crazydope\theater\database\adapter\PdoAdapter('pgsql:host=localhost;port=5432;dbname=crazydope;','crazydope','pass');
$tableGateway = new crazydope\theater\database\TableGateway('theater.movie',$adapter, new ResultSet(new Movie()));
$movieTable = new crazydope\theater\model\MovieTable($tableGateway,new IdentityMap());
//insert
$movie = new Movie();
$movie->setTitle('test')->setDescription('test record');
$movieTable->inset($movie);
$store = $movieTable->lastInsertId();
//update
$movie = $movieTable->getById($store);
$movie->setTitle('update title')->setDescription('update desc');
$movieTable->update($movie);
//delete
$movie = $movieTable->getById($store);
$movieTable->delete($movie->getId());
//list
$movies = $movieTable->getAll();