<?php

namespace App;

use \App\Util as Util;

class App extends Core
{

    public function run()
    {
        $this->response->send();
    }

}