<?php

namespace App\Http\Controllers;

use App\Models\YouTubeChannel;
use Illuminate\Http\Request;

class youTubeSpiderController extends Controller
{
    public function getFromYouTubeLink(Request $request)
    {

        $request->validate([
           'channel-link' => 'required' ,
        ]);

        $channelLink = $request->input('channel-link');

        $youtube_service = new \App\Services\YouTube\YouTube();
        $channels = $youtube_service->getYouTubeVideoByChannelUrl($channelLink);

        return view('youtube.youtubeSearchResult')->with('data', $channels);
    }
}
