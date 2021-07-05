<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('videos', function (Blueprint $table) {
                $table->id();
                $table->integer('channel_id');
                $table->string('youtube_video_id')->unique();
                $table->timestamp('published_at');
                $table->string('title');
                $table->string('description');
                $table->unsignedInteger('view_count')->default(0);;
                $table->unsignedInteger('like_count')->default(0);;
                $table->unsignedInteger('dislike_count')->default(0);;
                $table->unsignedInteger('favorite_count')->default(0);;
                $table->unsignedInteger('comment_count')->default(0);;
                $table->json('tags');
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
        Schema::dropIfExists('videos');
    }
}
