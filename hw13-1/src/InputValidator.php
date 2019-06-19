<?php

namespace TimGa\FillDb;

class InputValidator
{
    private $numOfMovies;

    public function validate(int $argc, array $argv) {
        if ($argc != 2) {
            throw new \Exception('Error: invalid number of arguments');
        }
        if (!is_numeric($argv[1])) {
            throw new \Exception('Error: input value must be numeric');
        }
        $this->numOfMovies = intval($argv[1]);
    }

    public function getNumOfMovies()
    {
        return $this->numOfMovies;
    }
}
