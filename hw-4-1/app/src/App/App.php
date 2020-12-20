<?php

namespace App;

use BracketsString\BracketsString;
use BracketsString\BracketsStringValidator;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * run the app
     */
    public function run (): void
    {
        $string         = trim($_POST['string'] ?? '');
        $bracketsString = new BracketsString($string);

        (new BracketsStringValidator($bracketsString))->validate();
    }
}