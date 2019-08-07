<?php

namespace App\Models;

use App\Model;

class Schedule extends Model
{
    public static $table = 'schedule';

    public $id;
    public $hall_number;
    public $film;
    public $start;
    public $price;

}