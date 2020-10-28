<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouTubeChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('you_tube_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('channel_id')->unique();
            $table->string('custom_url');
            $table->date('created_at');
            $table->date('updated_at');

            $table->index('custom_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('you_tube_channels');
    }
}
