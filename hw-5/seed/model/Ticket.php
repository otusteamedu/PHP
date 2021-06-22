<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class Ticket
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $session_id;
  private $seat_id;
  private $price;

  public function __construct() {
    $this->table = 'tickets';
    $this->fields = 'session_id, seat_id, price';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($session_id, $seat_id, $price) {
    $this->session_id = $session_id;
    $this->seat_id = $seat_id;
    $this->price = $price;
    if(!$this->session_id || !$this->seat_id || !$this->price) return false;

    $this->row_id = $this->saver->insert([$this->session_id, $this->seat_id, $this->price]);
    
    return $this->row_id;
  }

}