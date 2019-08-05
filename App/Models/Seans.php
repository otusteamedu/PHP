<?php

namespace App\Models;

use App\Model;

class Seans extends Model
{
    public static $table = 'seans';

    public $id;
    public $schedule_id;
    public $sold_tickets;
    public $day;

}