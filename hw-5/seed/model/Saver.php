<?php

namespace Model;

require_once 'Connection.php';
use Model\Connection;

class Saver
{
  private $connection;
  private $pdo;
  private $query;
  private $pre_insert;
  private $table;
  private $fields;
  private $values;
  private $row_id;

  public function __construct($table, $fields) {
    $this->table = $table;
    $this->fields = $fields;
    $fields_arr = explode(',', $fields);
    $val_to_insert = [];

    $this->connection = new Connection;
    $this->pdo = $this->connection->make();
    $this->query = "INSERT INTO ". $this->table ." (". $this->fields .") VALUES ";
    //Добавляем в шаблон нужное количество параметров. 
    //ToDo Переписать на основе регулярки
    for($i = 0; $i < count($fields_arr); $i++) {
      $val_to_insert[] = '?';
    }
    $this->query .= '('. implode(', ', $val_to_insert) .')';
    $this->pre_insert = $this->pdo->prepare($this->query);
  }

  public function insert($values) {
  	$this->values = $values;

    try {
      $this->pdo->beginTransaction();
      $this->pre_insert->execute($this->values);
      $this->pdo->commit();
    } catch (Exception $e) {
      $this->pdo->rollback();
      throw $e;
    }

    return $this->pdo->lastInsertId();
  }
}