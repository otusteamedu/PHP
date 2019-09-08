<?php

require_once __DIR__ . '/vendor/autoload.php';

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(__DIR__ . '/models');
    $cfg->set_connections(
        array(
            'development' => 'pgsql://postgres:otus2019@hw13-postgres/cinema',
        )
    );
    $cfg->set_default_connection('development');
});