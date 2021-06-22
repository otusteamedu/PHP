<?php

function autoload_model($class) {
  $class_name_arr = explode('\\', $class);
  $class_name = end($class_name_arr);
  include 'model/'. $class_name . '.php';
}

spl_autoload_register('autoload_model');