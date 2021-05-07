<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class NotAModelArgumentException extends \Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct("Only array of models inherited from App\\Models\\BaseModel may be passed to repository save methods!");
    }
}
