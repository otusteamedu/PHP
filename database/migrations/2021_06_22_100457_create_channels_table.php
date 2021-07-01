<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('channels', function (Blueprint $table) {
                $table->id();
                $table->string('youtube_channel_id')->unique();
                $table->string('title');
                $table->string('description');
                $table->timestamps();
            });
        } catch (\Illuminate\Database\QueryException $ex) {
            echo $ex->getMessage();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
