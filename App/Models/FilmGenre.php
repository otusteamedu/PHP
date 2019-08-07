<?php

namespace App\Models;

use App\Model;

class FilmGenre extends Model
{
    public static $table = 'film_genre';

    public $film_id;
    public $genre_id;

}