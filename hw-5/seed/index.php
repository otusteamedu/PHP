<?php

require_once 'seeder.php';

$answer = readline("Do you want to seed the DB? Y/n: ");
switch ($answer) {
  case 'Y':
    start_attr_types_seed();
    start_halls_seed();
    start_movie_seed();
    echo 'DB was successfully seeded'.PHP_EOL;
  break;
  case 'n':
    echo 'DB was not seeded'.PHP_EOL;
    break;
  default:
    echo 'Incorrect answer. Aborted'.PHP_EOL;
}

function start_movie_seed() {
  $movies_quantity = (int)readline("How much movies seed? Number: ");
  if(is_int($movies_quantity)) {
  	movie_seed($movies_quantity);
    echo $movies_quantity.' movies was seeded'.PHP_EOL;
  } else {
    echo 'No movies seeded'.PHP_EOL;
  }
}

function start_halls_seed() {
  $halls_quantity = (int)readline("How much halls seed? Number: ");
  if(is_int($halls_quantity)) {
  	hall_seed($halls_quantity);
    echo $halls_quantity.' halls was seeded'.PHP_EOL;
  } else {
    echo 'No halls seeded'.PHP_EOL;
  }
}

function start_attr_types_seed() {
  $create_types = readline("Do you want to seed Attr Types? Y/n: ");
  switch ($create_types) {
  case 'Y':
    movie_attr_type_seed();
    echo 'Types was successfully seeded'.PHP_EOL;
  break;
  case 'n':
    echo 'Types was not seeded'.PHP_EOL;
    break;
  default:
    echo 'Incorrect answer. Aborted'.PHP_EOL;
}
}