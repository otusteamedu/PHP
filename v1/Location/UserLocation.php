<?php

namespace App\Services\Location;


use Stevebauman\Location\Facades\Location;

class UserLocation
{
    protected $default;
    protected $ip;
    protected $position;

    const SESSION_KEY = 'Location';

    public function __construct()
    {
        $this->setDefault();
        $this->setIp();
    }

    public function get()
    {
        if(!$this->position){
            $this->position = $this->getFromSession();
        }
        return $this->position;
    }

    public function getSessionKey()
    {
        return self::SESSION_KEY;
    }

    public function getTimezone()
    {
        return $this->get()->timezone;
    }

    protected function getFromSession()
    {
        return session()->get(self::SESSION_KEY, $this->default);
    }

    public function find()
    {
        $position = Location::get($this->ip);

        if($position === false){ //if hasn't internet, in cache saved false value;
            $position = new \stdClass();
        }

        if(!optional($position)->latitude) {
            $position->latitude = $this->default->latitude;
        }
        if(!optional($position)->longitude) {
            $position->longitude = $this->default->longitude;
        }
        if(!optional($position)->timezone) {
            $position->timezone = $this->default->timezone;
        }

        return $position;
    }

    protected function setDefault()
    {
        $this->default = (object)config('location.default_position');
    }

    protected function setIp()
    {
        $ip = \Request::ip();

        if($ip === '127.0.0.1' && $this->isEnabledTestIp()){
            $ip = $this->default->ip;
        }

        $this->ip = $ip;
    }

    protected function isEnabledTestIp()
    {
        return config('location.testing.enabled');
    }
}