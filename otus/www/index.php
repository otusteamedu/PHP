<?php

require_once 'vendor/autoload.php';

$filmId = 1;

//////Обновление записи в таблице
$newFilm = \Classes\Models\Film::find($filmId);
$newFilm->setName('test 1');
$newFilm->save();

//Создание записи в таблице
$newRow = new \Classes\Models\Film();
$newRow->setName("Max Folder");
$newRow->save();

////
////Удаление записи в таблице
/** @var \Classes\Models\Film $rowObj */
$rowObj = \Classes\Models\Film::find($filmId);
$rowId = $rowObj->getId();
\Classes\Models\Film::delete($rowId);
