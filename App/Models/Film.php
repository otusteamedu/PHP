<?php

namespace App\Models;

use App\Model;

class Film extends Model
{
    public static $table = 'films';

    public $id;
    public $name;
    public $year;
}