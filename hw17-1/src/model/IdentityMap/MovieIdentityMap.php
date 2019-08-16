<?php

namespace TimGa\DbPatterns\Model\IdentityMap;

class MovieIdentityMap
{
    private static $instance;
    private $movies = [];

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): MovieIdentityMap
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public static function getMovieFromMap(int $movieId)
    {
        $inst = static::getInstance();
        if (isset($inst->movies[$movieId])) {
            return $inst->movies[$movieId];
        }
        return false;
    }

    public static function addMovieToMap(int $movieId, Movie $movie): void
    {
        $inst = static::getInstance();
        $inst->movies[$movieId] = $movie;
    }
}
