<?php

namespace App;

/**
 * Class Application
 * @package App
 */
class Application {

    public function start()
    {
        return Message::sendJsonOk();
    }
}
