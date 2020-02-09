<?php

namespace Youtube;

class Scanner {
    private $key = "";

    private $urls = [
        "channels" => "https://www.googleapis.com/youtube/v3/channels",
        "search" => "https://www.googleapis.com/youtube/v3/search"
    ];

    public function __construct(String $key) {
        $this->key = $key;
    }

    public function channels($channel_id) {
        $arr = [
            "part"=>"snippet",
            "id"=>$channel_id,
            "maxResults"=>10,
            "key" => $this->key
        ];
        $params = http_build_query($arr);
        $videoList = json_decode(file_get_contents( $this->urls["channels"]."?".$params  ));
        return $videoList;
    }
}