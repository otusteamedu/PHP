<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class MovieAttrType
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $name;

  public function __construct() {
    $this->table = 'movie_attr_types';
    $this->fields = 'name';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($name) {
    $this->name = $name;
    if(!$this->name) return false;

    $this->row_id = $this->saver->insert([$this->name]);
    
    return $this->row_id;
  }
}