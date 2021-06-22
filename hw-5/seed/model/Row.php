<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class Row
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $hall_id;
  private $row_num;
  private $seats_in_row;

  public function __construct() {
    $this->table = 'rows';
    $this->fields = 'hall_id, row_num, seats_in_row';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($hall_id, $row_num, $seats_in_row) {
    $this->hall_id = $hall_id;
    $this->row_num = $row_num;
    $this->seats_in_row = $seats_in_row;
    if(!$this->hall_id || !$this->row_num || !$this->seats_in_row) return false;

    $this->row_id = $this->saver->insert([$this->hall_id, $this->row_num, $this->seats_in_row]);
    
    return $this->row_id;
  }

}