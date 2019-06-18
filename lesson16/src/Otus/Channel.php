<?php

namespace Otus;
//
//  ["id"]=>
//  string(24) "UCiVZttFkdEwMi3QXpRqFTzQ"
//  ["snippet"]=>
//  object(stdClass)#11 (7) {
//    ["title"]=>
//    string(88) "Советское телевидение. ГОСТЕЛЕРАДИОФОНД России"
//    ["description"]=>
//    string(940) ""
//    ["customUrl"]=>
//    string(6) "gtrftv"
//    ["publishedAt"]=>
//    string(24) "2017-11-15T09:46:53.000Z"
//    ["country"]=>
//    string(2) "RU"
//  }
//  ["contentDetails"]=>
//  object(stdClass)#18 (1) {
//    ["relatedPlaylists"]=>
//    object(stdClass)#17 (3) {
//      ["uploads"]=>
//      string(24) "UUiVZttFkdEwMi3QXpRqFTzQ"
//    }
//  }
//  ["statistics"]=>
//  object(stdClass)#19 (5) {
//    ["viewCount"]=>
//    string(8) "56279290"
//    ["commentCount"]=>
//    string(1) "0"
//    ["subscriberCount"]=>
//    string(6) "224666"
//    ["hiddenSubscriberCount"]=>
//    bool(false)
//    ["videoCount"]=>
//    string(4) "5172"
//  }
//}

class Channel extends BaseRecord
{
    protected static $collectionName = 'channel';

    public function fromYouTubeData($data)
    {
        $this->setID($data->id);
        $this->setTitle($data->snippet->title);
        $this->setDescription($data->snippet->description);
        $this->setCustomUrl($data->snippet->customUrl);
        $this->setPublishedAt($data->snippet->publishedAt);
        $this->setCountry($data->snippet->country);
        $this->setUploads($data->contentDetails->relatedPlaylists->uploads);
        $this->setStatistics($data->statistics);
    }
}