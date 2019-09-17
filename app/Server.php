<?php

namespace App;

class Server extends AbstractChat
{
    public function init()
    {
        $this->transport->serve();

        $this->chat();
    }
}
