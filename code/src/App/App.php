<?php

namespace App;

use Validate\Validate;

class App
{

    public function run ()
    {

        $emails = file($_ENV['LIST_PATH']);

        foreach($emails as $email)
        {
            $validate = new Validate();
            $validate->validate(trim($email));
        }



    }
}