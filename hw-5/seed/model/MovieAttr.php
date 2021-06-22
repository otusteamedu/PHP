<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class MovieAttr
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $type_id;
  private $name;

  public function __construct() {
    $this->table = 'movie_attrs';
    $this->fields = 'type_id, name';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($type_id, $name) {
    $this->type_id = $type_id;
    $this->name = $name;
    if(!$this->type_id || !$this->name) return false;

    $this->row_id = $this->saver->insert([$this->type_id, $this->name]);
    
    return $this->row_id;
  }

}