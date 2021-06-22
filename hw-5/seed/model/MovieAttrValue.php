<?php

namespace Model;

require_once 'Saver.php';
use Model\Saver;

class MovieAttrValue
{
  private $table;
  private $fields;
  private $saver;
  private $row_id;
  private $movie_id;
  private $attr_id;
  private $val_text;
  private $val_float;
  private $val_int;
  private $val_date;

  public function __construct() {
    $this->table = 'movie_attr_values';
    $this->fields = 'movie_id, attr_id, val_text, val_float, val_int, val_date';
    $this->saver = new Saver($this->table, $this->fields);
  }

  public function insert($movie_id, $attr_id, $val_text, $val_float, $val_int, $val_date) {
    $this->movie_id = $movie_id;
    $this->attr_id = $attr_id;
    $this->val_text = $val_text;
    $this->val_float = $val_float;
    $this->val_int = $val_int;
    $this->val_date = $val_date;
    if(!$this->movie_id || !$this->attr_id || !$this->val_text && !$this->val_float && !$this->val_int && !$this->val_date) return false;

    $this->row_id = $this->saver->insert([$this->movie_id, $this->attr_id, $this->val_text, $this->val_float, $this->val_int, $this->val_date]);
    
    return $this->row_id;
  }

}