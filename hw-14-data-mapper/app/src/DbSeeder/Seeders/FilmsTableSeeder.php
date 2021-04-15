<?php

namespace App\DbSeeder\Seeders;

use App\Log\Log;
use App\Models\FilmDTO;
use App\Models\FilmMapper;
use App\Storage\Storage;
use Exception;
use Faker\Factory;

class FilmsTableSeeder implements SeederInterface
{
    const TABLE_NAME         = 'films';
    const FAKE_RECORDS_COUNT = 50;

    public function execute (): bool
    {
        Log::getInstance()->addRecord('creating table ' . self::TABLE_NAME);

        $sql = '
        CREATE TABLE IF NOT EXISTS films
        (
            id              serial       NOT NULL,
            title           varchar(100) NOT NULL,
            show_start_date timestamp    NOT NULL,
            length          int4         NOT NULL,
            CONSTRAINT films_pk PRIMARY KEY (id),
            CONSTRAINT films_title_and_date_un UNIQUE (title, show_start_date)
        );
        ';

        $tableCreated = Storage::getInstance()->exec($sql);

        if ($tableCreated === false) {
            throw new Exception('table ' . self::TABLE_NAME . 'creation error');
        }

        Log::getInstance()->addRecord(self::TABLE_NAME . ' table created');
        Log::getInstance()->addRecord('filling table ' . self::TABLE_NAME);

        for ($i = 1; $i <= self::FAKE_RECORDS_COUNT; $i++) {
            self::insertFakeRecord();
        }

        return true;
    }

    private static function insertFakeRecord (): void
    {
        $pdo = Storage::getInstance();

        $filmMapper = (new FilmMapper($pdo));

        $filmMapper->insert(self::getFakeRecord());
    }

    private static function getFakeRecord (): FilmDTO
    {
        $faker = Factory::create();

        return new FilmDTO(
            $faker->name,
            $faker->date('Y-m-d h:i:00'),
            $faker->numberBetween(80, 240)
        );
    }
}
