<?php

/**
 * Identity map
 */

namespace HW;


use HW\ActiveRecords\Film;

class Films
{
    /** @var Film[] */
    private static $instances = [];

    private function __construct()
    {
    }

    /**
     * @param \PDO $pdo
     * @param $filmID
     * @return Film|null
     */
    public function getFilm(\PDO $pdo, $filmID)
    {
        /** @var Film $result */
        $result = null;
        foreach (self::$instances as $film) {
            if ($film->getId() == $filmID) {
                $result = $film;
                break;
            }
        }

        if (!$result) {
            $result = Film::getById($pdo, $filmID);
            if ($result)
                self::$instances[] = $result;
        }

        return $result;
    }

}