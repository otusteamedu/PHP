<?php

namespace v2\Location;


use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;


class UserLocation
{
    protected Position $default;
    protected string $ip;
    protected Position $position;

    private const SESSION_KEY = 'Location';

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

    public function getSessionKey() : string
    {
        return self::SESSION_KEY;
    }

    public function getTimezone()
    {
        return $this->get()->timezone;
    }

    public function find()
    {
        $position = Location::get($this->ip);

        if($position === false){ //if hasn't internet, in cache saved false value;
            $position = new Position();
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

    protected function getFromSession()
    {
        return session()->get(self::SESSION_KEY, $this->default);
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