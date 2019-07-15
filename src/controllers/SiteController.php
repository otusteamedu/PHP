<?php
namespace Paa\Controllers;

use Paa\Models\MongoModel;
use Paa\Models\YoutubeModel;

class SiteController
{

    public function __construct()
    {
	global $config;
        $this->url = $config['youtube']['url'];
        $this->depth = $config['youtube']['depth'];

    }
                                    

    public function actionIndex()
    {

	$this->crawlerPages();

	$mongoObj = new MongoModel();
	$cursor = $mongoObj->selectMongo();
	
	$asset['channelsList'] = $cursor;

        $result = [ 'asset' => $asset, 'type' => 'html' ];
        
        return $result;
    }
    


    public function crawlerPages(string $url = '')
    {

	$mongoObj = new MongoModel();
	
	if ($url === '') $url = $this->url;
	
	$youtubeObj = new YoutubeModel();
	$channelsList = $youtubeObj->getUrls($url);
	
	foreach ($channelsList as $indx => $val) {
	    $getChannel = $youtubeObj->getChannelInfo($val, $indx);
	    
	    if (!is_null($getChannel['channelInfo']['channelId'])) {
		$channelAdd = $mongoObj->insertMongoChannel($getChannel['channelInfo']['channelId'], $getChannel['channelInfo']['channelTitle'], $getChannel['channelStatistic']['viewCount'], $getChannel['channelStatistic']['likeCount'], $getChannel['channelStatistic']['dislikeCount']);
		if (!$channelAdd) {
		    $mongoObj->updateMongoChannel($getChannel['channelInfo']['channelId'], $getChannel['channelInfo']['channelTitle'], $getChannel['channelStatistic']['viewCount'], $getChannel['channelStatistic']['likeCount'], $getChannel['channelStatistic']['dislikeCount']);
		}
		
		foreach ($getChannel['channelVideos'] as $indx1 => $val1) {
		    if (!is_null($val1['videoId'])) {
		        $mongoObj->insertMongoVideo($val1['videoId'], $getChannel['channelInfo']['channelId'], $val1['videoTitle'], $val1['videoViews'], $val1['videoLikes'], $val1['videoDislikes']);
		    }
		}
		
	    }

	}
    }
}