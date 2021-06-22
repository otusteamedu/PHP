<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class Seat
{
  private $table;
  private $fields;
  private $saver;
  private $id;
  private $row_id;
  private $seat_num;

  public function __construct() {
    $this->table = 'seats';
    $this->fields = 'row_id, seat_num';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($row_id, $seat_num) {
    $this->row_id = $row_id;
    $this->seat_num = $seat_num;
    if(!$this->row_id || !$this->seat_num) return false;

    $this->id = $this->saver->insert([$this->row_id, $this->seat_num]);
    
    return $this->id;
  }
}