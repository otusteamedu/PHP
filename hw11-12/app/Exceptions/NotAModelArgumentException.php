<?php

namespace App\Exceptions;

use Throwable;

class NotAModelArgumentException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Only array of models inherited from App\\Models\\BaseModel may be passed to repository save methods!");
    }
}
