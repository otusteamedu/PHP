<?php

namespace Otus;

/**
 * Class FilmModel
 * @package Otus
 */
class FilmModel extends BaseModel
{
    /**
     * @var string
     */
    protected static $tableName = 'film';

    /**
     * @var array
     */
    protected $fields = ['id', 'title', 'genre_id', 'duration', 'annotation'];

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $genre_id;

    /**
     * @var int
     */
    public $duration;

    /**
     * @var string
     */
    public $annotation;

}