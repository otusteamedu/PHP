<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YouTubeStatisticController extends Controller
{
    private \App\Repositories\YouTube\YouTubeStatisticsRepository $youStatistic;

    public function __construct() {
        $this->youStatistic = app(\App\Repositories\YouTube\YouTubeStatisticsRepository::class);
    }

    public function index() {
        return view('youtube.youTubeStatistic');
    }

    public function getChannelStatistics(Request $request) {

        $request->validate([
            'channel-name' => 'required' ,
        ]);

        $channelName= $request->input('channel-name');

        $r = $this->youStatistic->getStatisticByChannelName($channelName);

        return view('youtube.youtubeStatisticResult')->with('data', $r);
    }

    public function getTopChannel() {
        $r = $this->youStatistic->getTopChannelsByDifferenceLikesDislikes();
        return view('youtube.youTubeTopChannels')->with('data', $r);
    }
}
