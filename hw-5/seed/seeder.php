<?php

require_once 'autoloader.php';

use Model\Movie;
use Model\MovieAttr;
use Model\MovieAttrType;
use Model\MovieAttrValue;
use Model\Hall;
use Model\Row;
use Model\Seat;

function movie_attr_type_seed() {
	$types = ['TEXT', 'FLOAT', 'INTEGER', 'DATE'];
    $movie_attr_type = new MovieAttrType;

	foreach($types as $type) {
      $movie_attr_type->insert($type);
	}
}

function movie_seed($movies_count) {
  $movie = new Movie;
  $movie_attr = new MovieAttr;
  $movie_attr_value = new MovieAttrValue;

  for($i = 1; $i <= $movies_count; $i++) {
  	$film_name_1 = ['Мой', 'Красный', 'Старый', 'Вечный', 'Эпичный', 'Серёгин'];
  	$film_name_2 = ['замок', 'друг', 'проект', 'котенок', 'поход', 'пингвин'];
  	$film_name_3 = ['просто обречен на успех', 'никогда не был на море', 'снова выйграл', 'помогает всем', 'когда-то был здесь', 'встал на тропу мира'];
  	$attrs = [
      [4, 'Премьера', null, null, null, '2021-08-15'],
      [3, 'Бюджет фильма', null, null, 3000000, null],
      [2, 'Оценка от всезнаек', null, '7.8', null, null],
      [1, 'Отзыв профессионала', 'Достойно', null, null, null],
  	];
    
    $movie_id = $movie->insert($film_name_1[random_int(0, 5)] .' '. $film_name_2[random_int(0, 5)] .' '. $film_name_3[random_int(0, 5)]);
    
    foreach($attrs as $attr) {
      $movie_attr_id = $movie_attr->insert($attr[0], $attr[1]);
      $movie_attr_value->insert($movie_id, $movie_attr_id, $attr[2], $attr[3], $attr[4], $attr[5]);
    }

  }

}

function hall_seed($halls_count) {
  $hall = new Hall;
  $row = new Row;
  $seat = new Seat;
  $hall_name = 'Зал номер ';
  $hall_id;
  $row_id;
  $seats_in_row;
  
  //Создаём залы
  for($i = 1; $i <= $halls_count; $i++) {
  	$hall_id = $hall->insert($hall_name.$i);

    //Создаём ряды в зале
  	for($j = 1; $j <= 25; $j++) {
  	  $seats_in_row = 15 + $j;
  	  $seats_in_row = $seats_in_row > 26 ? 26 : $seats_in_row;

      $row_id = $row->insert($hall_id, $j, $seats_in_row);
      
      //Записываем места в ряду
      for($k = 1; $k <= $seats_in_row; $k++) {
      	$seat->insert($row_id, $k);
      }

  	}

  }

}
