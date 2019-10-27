<?php

namespace App;

class Client extends AbstractChat
{
    public function init()
    {
        $this->transport->connect();

        $this->chat();
    }
}
