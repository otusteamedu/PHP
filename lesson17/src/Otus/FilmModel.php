<?php

namespace Otus;

class FilmModel extends BaseModel
{
    protected $tableName = 'film';
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