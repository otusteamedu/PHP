<?php

namespace App;

use App\Contracts\Output;

class StdOut implements Output
{
    public function write(string $string)
    {
        stream_set_blocking(STDOUT, false);
        fwrite(STDOUT, $string . PHP_EOL);
    }
}
