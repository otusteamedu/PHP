<?php


namespace App\Models;


class YoutubeChannel
{
    public $channelId;
    public $title;
    public $description;
    public $customUrl;
    public $country;
    public $videoIds = [];
}