<?php

require __DIR__ . '/../../bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;


Capsule::schema()->create('articles', function ($table) {
    $table->increments('id');
    $table->string('category');
    $table->string('format');
    $table->string('name');
    $table->string('body');
    $table->timestamps();
});