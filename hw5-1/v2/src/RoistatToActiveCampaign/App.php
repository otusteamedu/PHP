<?php

namespace RoistatToActiveCampaign;

Class App {

    protected $action;

    public function run() {

        if(!array_key_exists('action', $_REQUEST)) {
            throw new \Exception('action not set');
        }


    }
}