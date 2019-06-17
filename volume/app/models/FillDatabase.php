<?php


namespace hw13\models;

use ActiveRecord\Model as ActiveRecord;
use Exception;

/**
 * Class FillDatabase
 * @package hw13\models
 */
class FillDatabase
{
    const CONSOLE_ERROR = 1;
    const CONSOLE_SUCCESS = 2;

    protected $count;

    /**
     * FillDatabase constructor.
     * @param int $count
     * @throws Exception
     */
    public function __construct(int $count)
    {
        if ($count < 0 || $count > 10000000) {
            throw new Exception(self::getConsoleMsg(self::CONSOLE_ERROR, "Fill count must be between 0 and 10000000"));
        }
        $this->count = $count;
    }

    /**
     * migration
     * @throws \Exception
     */
    public static function migrate()
    {
        if (MovieAttributeCateg::count() === 0 && MovieAttributeType::count() === 0) {
            MovieAttributeCateg::transaction(function () {
                $attributeCategs = MovieAttributeCateg::ALL_CATEGS;
                foreach ($attributeCategs as $acKey => $acValue) {
                    (new self(0))->insertMovieAttributeCateg($acKey, $acValue);
                }
            });

            echo "INSERT IN movie_attribute_categ " . self::getConsoleMsg(self::CONSOLE_SUCCESS, 'done!') . "\n";

            MovieAttributeCateg::transaction(function () {
                $attributeTypes = MovieAttributeType::ALL_TYPES;
                foreach ($attributeTypes as $atKey => $atValue) {
                    (new self(0))->insertMovieAttributeType($atKey, $atValue);
                }
            });

            echo "INSERT IN movie_attribute_type " . self::getConsoleMsg(self::CONSOLE_SUCCESS, 'done!') . "\n";
        }
    }

    public static function deleteAllMovies()
    {
        MovieAttribute::delete_all();
        MovieAttributeValue::delete_all();
        MovieAttributeName::delete_all();
        Movie::delete_all();

        echo "DELETE all movies " . self::getConsoleMsg(self::CONSOLE_SUCCESS, 'done!') . "\n";;
    }

    /**
     * Start point
     * @throws \Exception
     */
    public function fill()
    {
        $executionStartTime = microtime(true);
        for ($i = 0; $i < $this->count; $i++) {
            Movie::transaction(function () {
                $movieId = $this->insertMovie();
                foreach (MovieAttributeType::ALL_TYPES as $matKey => $matValue) {
                    if ($matKey === MovieAttributeType::INTEGER) {
                        $this->insertMovieAttribute(
                            $movieId,
                            $this->insertMovieAttributeName('Сборы в мире'),
                            $matKey,
                            $this->insertMovieAttributeValue($matValue, rand(15, 100) * 1000000),
                            MovieAttributeCateg::INCOME
                        );
                    } elseif ($matKey === MovieAttributeType::TIMESTAMP) {
                        $this->insertMovieAttribute(
                            $movieId,
                            $this->insertMovieAttributeName('Премьера в мире'),
                            $matKey,
                            $this->insertMovieAttributeValue($matValue, date("Y-m-d H:i:s", mt_rand(1558483200, 1633910400))),
                            MovieAttributeCateg::IMPORTANT_DATES
                        );
                    } elseif ($matKey === MovieAttributeType::TEXT) {
                        $this->insertMovieAttribute(
                            $movieId,
                            $this->insertMovieAttributeName('Рецензия'),
                            $matKey,
                            $this->insertMovieAttributeValue($matValue, substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(500 / strlen($x)))), 1, 500)),
                            MovieAttributeCateg::REVIEW
                        );
                    } elseif ($matKey === MovieAttributeType::BOOLEAN) {
                        $this->insertMovieAttribute(
                            $movieId,
                            $this->insertMovieAttributeName('Печать наград на билетах'),
                            $matKey,
                            $this->insertMovieAttributeValue($matValue, rand(0, 1)),
                            MovieAttributeCateg::REWARDS
                        );
                    }
                }
            });
        }

        $executionEndTime = microtime(true);
        $seconds = $executionEndTime - $executionStartTime;

        echo self::getConsoleMsg(self::CONSOLE_SUCCESS, "$this->count movies with args added to db in $seconds sec!") . "\n";
    }

    public static function generateName(): string
    {
        $letters = [
            'ко', 'и', 'дзу', 'ми',
            'са', 'ку', 'ра', 'да',
            'чи', 'а', 'ки', 'ми',
            'на', 'го', 'ха', 'ру'
        ];

        shuffle($letters);
        return join(array_slice($letters, 0, 4));
    }

    public function insertData(ActiveRecord $object, array $params): int
    {
        $object->set_attributes($params);
        if ($object->save()) {
            return (int)$object->attributes()['id'];
        } else {
            return 0;
        }
    }


    public function insertMovie(): int
    {
        return self::insertData(new Movie(), [
            'name' => self::generateName()
        ]);
    }

    public function insertMovieAttribute(int $movie, int $name, int $type, int $value, $categ = null): bool
    {
        return self::insertData(new MovieAttribute(), [
            'movie' => $movie,
            'name' => $name,
            'type' => $type,
            'value' => $value,
            'categ' => $categ,
        ]);
    }

    public function insertMovieAttributeName(string $name): int
    {
        return self::insertData(new MovieAttributeName(), [
            'name' => $name
        ]);
    }

    public function insertMovieAttributeType(int $id, string $name): int
    {
        return self::insertData(new MovieAttributeType(), [
            'id' => $id,
            'name' => $name
        ]);
    }

    public function insertMovieAttributeValue(string $type, $value): int
    {
        $params = [];

        switch ($type) {
            case 'integer':
                $params['value_int'] = $value;
                break;
            case 'timestamp':
                $params['value_datetime'] = $value;
                break;
            case 'text':
                $params['value_text'] = $value;
                break;
            case 'boolean':
                $params['value_bool'] = $value;
                break;
        }

        return self::insertData(new MovieAttributeValue(), $params);
    }

    public function insertMovieAttributeCateg(int $id, string $name)
    {
        return self::insertData(new MovieAttributeCateg(), [
            'id' => $id,
            'name' => $name
        ]);
    }

    public static function getConsoleMsg(int $type, string $msg): string
    {
        if ($type === self::CONSOLE_ERROR) {
            return "\e[31m$msg\e[39m";
        } elseif ($type === self::CONSOLE_SUCCESS) {
            return "\e[32m$msg\e[39m";
        }
    }
}