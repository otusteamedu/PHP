<?php

namespace App;

use App\Contracts\Input;

class StdIn implements Input
{
    public function read(): string
    {
        stream_set_blocking(STDIN, false);
        return fgets(STDIN);
    }
}
