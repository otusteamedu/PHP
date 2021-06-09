<?php


namespace App;


use Laravel\Lumen\Application;

/**
 * Class App
 * @package App
 */
class App extends Application
{

    public function path()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'App';
    }
}