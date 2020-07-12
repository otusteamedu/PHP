<?php

namespace App\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('deliveryDiscounts', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('discount');
});
