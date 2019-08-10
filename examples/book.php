<?php

require '../vendor/autoload.php';

use hw23\models\Book;
use hw23\App;

$app = new App();


var_dump(Book::getOne(['id' => 3]));

var_dump(Book::getAll(['composition_id' => 15]));

var_dump(Book::getById(1) === Book::getById(1));