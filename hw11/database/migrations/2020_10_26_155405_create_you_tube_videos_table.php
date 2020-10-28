<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouTubeVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('you_tube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_id')->unique();
            $table->string('title');
            $table->unsignedInteger('likes_count');
            $table->unsignedInteger('dislikes_count');
            $table->unsignedBigInteger('views_count');
            $table->string('channel_id');
            $table->date('created_at');
            $table->date('updated_at');

            $table->foreign('channel_id')->references('channel_id')->on('you_tube_channels');
            $table->index('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('you_tube_videos');
    }
}
