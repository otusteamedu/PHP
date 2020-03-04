<?php

namespace App;

class Main
{
    public function run(): void
    {
        echo '<pre>';
        print_r($_SERVER);
        echo '</pre>';
    }
}
