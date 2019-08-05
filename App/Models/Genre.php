<?php

namespace App\Models;

use App\Model;

class Genre extends Model
{
    public static $table = 'genres';

    public $id;
    public $name;
}