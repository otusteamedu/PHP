<?php

require_once 'vendor/autoload.php';

use TimGa\FillDb\DataEraser;
use TimGa\FillDb\DataInserter;
use TimGa\FillDb\InputValidator;

// Get number of movies to generate from user input
$validator = new InputValidator;
$validator->validate($argc, $argv);
$numOfMovies = $validator->getNumOfMovies();

// Clear tables movie, schedule and ticket before inserting test data
$eraser = new DataEraser();
$eraser->start();

// insert test data into tables movie, schedule and ticket
$inserter = new DataInserter;
$inserter->insertMovies($numOfMovies);
$inserter->insertScheduleAndTickets($numOfMovies);
$inserter->closeDbConnection();
