<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class Session
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $hall_id;
  private $movie_id;
  private $price;

  public function __construct() {
    $this->table = 'sessions';
    $this->fields = 'hall_id, movie_id, price';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($hall_id, $movie_id, $price) {
    $this->hall_id = $hall_id;
    $this->movie_id = $movie_id;
    $this->price = $price;
    if(!$this->hall_id || !$this->movie_id || !$this->price) return false;

    $this->row_id = $this->saver->insert([$this->hall_id, $this->movie_id, $this->price]);
    
    return $this->row_id;
  }

}