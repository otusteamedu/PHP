<?
namespace Paa\Models;

use Paa\App\YoutubeController;

class YoutubeModel extends YoutubeController
{
    
    public function __construct() 
    {
	global $config;
        $this->config = parent::__construct();
        $this->key = $config['youtube']['key'];
        
    }


    public function getUrls(string $url  = '') : array
    {
	$urls = [];
	if ($url != '') {
	    $data = file_get_contents($url);
	    preg_match_all('/\"\/(channel|user)\/(.*?)\"/i', $data, $match);
	
	    $i = 0;
	    foreach($match[0] as $val) {
		$urls[$match[2][$i]] = $match[1][$i];
		$i++;
	    }
	}

	return $urls;
    }
    
    public function getChannelInfo(string $channelType = '', string $channelId = '') //: array
    {
	$ykey = $this->key;
	
	$channelInfo = [];
	$channelStatistic = [];
	$channelVideos = [];
	
	if ($channelType === 'user') {
	    $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername=".$channelId."&key=".$ykey;
	    $api_channel = $this->get_ydata($channelUrl);
	    $ychannel = json_decode($api_channel);
	    
	    if ($ychannel && $ychannel != NULL && $ychannel->items) {
	        foreach ($ychannel->items as $item) {
	    	    if ($item->id != "") {
	    		$channelId = $item->id;
	    		break;
	    	    }
		} 
	    } else {
		$channelId = "";
	    }
	}
	
	if ($channelId != ""){
	    $api_channel_list = $this->get_ydata("https://www.googleapis.com/youtube/v3/search?order=date&maxResults=50&part=snippet&channelId=".$channelId."&key=".$ykey);
	    
	    $channel_list = json_decode($api_channel_list);
	    
	    // Get data from first video about channel
	    if (isset($channel_list->items) && !isset($channel_list->error->errors)) {
		$channelInfo = [ 'channelId' => $channelId, 'channelTitle' => $channel_list->items[0]->snippet->channelTitle ];
		$viewCount = 0;
		$likeCount = 0;
		$dislikeCount = 0;
		
		foreach ($channel_list->items as $video) {
		    $api_video = $this->get_ydata("https://www.googleapis.com/youtube/v3/videos?id=".$video->id->videoId."&part=snippet%2Cstatistics%2CcontentDetails&key=".$ykey);
		    $videoItem = json_decode($api_video);
		    
		    $viewCount = $viewCount + (int)$videoItem->items[0]->statistics->viewCount;
		    $likeCount = $likeCount + (int)$videoItem->items[0]->statistics->likeCount;
		    $dislikeCount = $dislikeCount + (int)$videoItem->items[0]->statistics->dislikeCount;

		    $channelVideos[] = [ 
					'videoId' => $videoItem->items[0]->id,
					'videoTitle' => $videoItem->items[0]->snippet->title, 
				        'videoViews' => (int)$videoItem->items[0]->statistics->viewCount, 
					'videoLikes' => (int)$videoItem->items[0]->statistics->likeCount, 
					'videoDislikes' => (int)$videoItem->items[0]->statistics->dislikeCount 
				    ];
		    
		}

		$channelStatistic = [ 'viewCount' => $viewCount, 'likeCount' => $likeCount, 'dislikeCount' => $dislikeCount ];
    	    }
    	    
    	}

	return [ "channelInfo" => $channelInfo, "channelStatistic" => $channelStatistic, "channelVideos" => $channelVideos ];
    }
    
    
    public function get_ydata($url) {
	$ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
                                                
    

}
