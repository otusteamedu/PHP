<?php

namespace App;

use Validate\Validate;

class App
{

    public function run ()
    {
        $string = trim($_POST['string'] ?? '');

        $validate = new Validate();
        $validate->validate($string);

    }
}