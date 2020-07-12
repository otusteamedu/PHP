<?php

namespace App\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('orders', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->integer('clientId');
    $table->integer('couponId');
    $table->integer('price');
    $table->foreign('clientId')->references('id')->on('clients')
        ->onDelete('cascade');
    $table->foreign('couponId')->references('id')->on('coupons')
        ->onDelete('cascade');
});
