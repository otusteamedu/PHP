<?php

namespace RoistatToActiveCampaign;

Class App {

    public function run()
    {
        if(!array_key_exists('action', $_REQUEST)) {
            throw new \Exception('action not set');
        }

        $client = new RoistatClient($_REQUEST['action']);

        $client->getData();
    }
}