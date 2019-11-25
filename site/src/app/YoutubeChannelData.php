<?php
namespace App;


interface YoutubeChannelData{
    public function getVideosChannelIds($channelDefaultId);
    public function getChannelInfo($idChannel);

}
