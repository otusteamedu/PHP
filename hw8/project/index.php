<?php
require_once 'vendor/autoload.php';
use MyTestLib\Source\InputOutputProcessor;

$processor = new InputOutputProcessor();
$processor->printToStdOut("Тест завершен успешно");
