<?php


namespace hw13\models;

/**
 * Class FillDatabase
 * @package hw13\models
 */
class FillDatabase
{
    protected $count;

    /**
     * FillDatabase constructor.
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->count = $count;
    }

    /**
     * Start point
     */
    public function execute()
    {
        $this->insertMovie($this->count);
    }

    public static function generateName(): string
    {
        $letters = [
            'ко',   'и',    'дзу',  'ми',
            'са',   'ку',   'ра',   'да',
            'чи',   'а',    'ки',   'ми',
            'на',   'го',   'ха',   'ру'
        ];

        shuffle($letters);
        return  join(array_slice($letters, 0, 4));
    }


    public function insertMovie(int $count): bool
    {
        $movie = new Movie([
            'name' => self::generateName()
        ]);
        return $movie->save();
    }
}