<?php


namespace App\Models;


use App\Database\ModelCollection;

class Seance extends \App\Database\Model
{

    protected $table = 'seances';

    public function movie(): Movie
    {
        return Movie::find($this->movie_id, ['id']);
    }

}