<?php

namespace App;

use Bjlag\PhpInfo;

class Main
{
    public function run(): void
    {
        (new PhpInfo())->show();
    }
}
