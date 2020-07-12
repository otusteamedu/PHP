<?php

namespace App\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('deliveryServices', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->integer('tariff');
    $table->integer('deliveryDiscountId');
    $table->integer('priceWithDiscount');
    $table->integer('maxSize');
    $table->foreign('deliveryDiscountId')->references('id')->on('deliveryDiscounts')
        ->onDelete('cascade');
});
