<?php

namespace App\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('clients', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->string('address');
});