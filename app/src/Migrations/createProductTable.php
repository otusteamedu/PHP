<?php

namespace App\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('products', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->integer('price');
    $table->integer('size');
    $table->integer('priceWithDiscount');
    $table->integer('productDiscountId');
    $table->string('type');
    $table->foreign('productDiscountId')->references('id')->on('productDiscounts')
        ->onDelete('cascade');
});